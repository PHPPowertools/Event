<?php

/* !
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *               PACKAGE : PHP POWERTOOLS
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *               COMPONENT : EVENT 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 *               DESCRIPTION :
 *
 *               A library for easy event handling
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 *               REQUIREMENTS :
 *
 *               PHP version 5.4
 *               PSR-0 compatibility
 *
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * 
 *               LICENSE :
 *
 * LICENSE: Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  @category  Event handling
 *  @package   Event
 *  @author    John Slegers
 *  @copyright MMXV John Slegers
 *  @license   http://www.opensource.org/licenses/mit-license.html MIT License
 *  @link      https://github.com/jslegers
 * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

namespace PowerTools;

class Event_Emitter {

    public static $defaultMaxListeners = 10;
    protected $_maxListeners = NULL;
    protected $_events = [];

    protected function _removeIndex($type, $k) {
        unset($this->_events[$type][$k]);
        if (empty($this->_events[$type])) {
            unset($this->_events[$type]);
        }
    }

    public static function factory() {
        return new static();
    }

    public function addListener($type, $listener, $options = []) {
        $options['scope'] = isset($options['scope']) ? $options['scope'] : NULL;
        $options['calls'] = isset($options['calls']) ? $options['calls'] : INF;
        if ($this->listenerCount($type) < $this->getMaxListeners()) {
            $this->_events[$type][] = Event_Listener::factory($listener, $options);
        } else {
            throw new Exception('Maximum number of listeners reached for event ' . $type . ' on an object of class ' . get_class());
        }
        return $this;
    }

    public function addListeners($type, $listeners, $options = []) {
        foreach ($listeners as $listener) {
            $this->addListener($type, $listener, $options);
        }
        return $this;
    }

    public function once($type, $listener, $options = []) {
        $options['calls'] = 1;
        return $this->addListener($type, $listener, $options);
    }

    public function removeListener($type, $listener, $options = []) {
        if (isset($this->_events[$type])) {
            $options['once'] = isset($options['once']) ? $options['once'] : true;
            $found = false;
            foreach ($this->_events[$type] as $k => $l) {
                if ($l->getFunction() === $listener) {
                    $this->_removeIndex($type, $k);
                    if (!$found && $options['once']) {
                        return $this;
                    } else {
                        $found = true;
                    }
                }
            }
        }
        return $this;
    }

    public function removeListeners($type, $listeners) {
        foreach ($listeners as $listener) {
            $this->removeListener($type, $listener);
        }
        return $this;
    }

    public function removeAllListeners($type = NULL) {
        if ($type === NULL) {
            foreach ($this->_events as $type => $eventList) {
                $this->removeAllListeners($type);
            }
        } else {
            foreach ($this->_events[$type] as $listener) {
                $this->removeListener($type, $listener->getFunction());
            }
        }
        return $this;
    }

    public function setMaxListeners($n = NULL) {
        $this->_maxListeners = ($n === 0) ? INF : $n;
        return $this;
    }

    public function getMaxListeners() {
        if ($this->_maxListeners === NULL) {
            if (static::$defaultMaxListeners === 0) {
                return INF;
            }
            return static::$defaultMaxListeners;
        }
        return $this->_maxListeners;
    }

    public function listeners($type) {
        if (isset($this->_events[$type])) {
            return $this->_events[$type];
        } else {
            return [];
        }
    }

    public function emit() {
        $args = func_get_args();
        $type = array_shift($args);
        if (isset($this->_events[$type])) {
            foreach ($this->_events[$type] as $k => $f) {
                $f->call($args);
                if ($f->callsLeft > 1) {
                    $f->callsLeft--;
                } else {
                    $this->_removeIndex($type, $k);
                }
            }
            return true;
        }
        return false;
    }

    public function listenerCount($type) {
        if (isset($this->_events[$type])) {
            return count($this->_events[$type]);
        } else {
            return 0;
        }
    }

    public function dispatch(Event $event) {
        $target = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];
        if (isset($target['object'])) {
            $event->target = $target['object'];
        } elseif (isset($target['class'])) {
            $event->target = $target['class'];
        } else {
            $event->target = NULL;
        }
        return $this->emit($event->type, $event);
    }

}

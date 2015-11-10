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

class Event_Listener {

    protected $_scoped;
    protected $_scope;
    protected $_unscoped;
    public $callsLeft;

    protected function _setScoped() {
        if ($this->_scope === NULL) {
            $this->_scoped = $this->_unscoped;
        } else {
            $this->_scoped = \Closure::bind($this->_unscoped, $scope);
        }
        return $this;
    }

    public static function factory($callable, $options) {
        return new static($callable, $options);
    }

    public function __construct($callable, $options) {
        $this->_unscoped = $callable;
        $this->_scope = isset($options['scope']) ? $options['scope'] : NULL;
        $this->callsLeft = isset($options['calls']) ? $options['calls'] : INF;
        $this->_setScoped();
    }

    public function setScope($scope = NULL) {
        $this->_scope = $scope;
        $this->_setScoped();
        return $this;
    }

    public function setFunction($callable) {
        $this->_unscoped = $callable;
        $this->_setScoped();
        return $this;
    }

    public function getScope() {
        return $this->_scope;
    }

    public function getFunction() {
        return $this->_unscoped;
    }

    public function call($args) {
        call_user_func_array($this->_scoped, $args);
        return $this;
    }

}
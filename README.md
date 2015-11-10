# Event Component

***[PHPPowertools](https://github.com/PHPPowertools)*** is a web application framework for PHP > 5.4.

***[PHPPowertools/DOM-Query](https://github.com/PHPPowertools/DOM-Query)*** is the third component of the ***PHPPowertools*** that has been released to the public.

The purpose of this component is to provide a ***[jQuery](http://jquery.com/)*** a PHP-based event handling interface similar to both NodeJS's ***[EventEmitter](https://nodejs.org/api/events.html#events_class_events_eventemitter)*** and your browser's ***[EventTarget](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget)***.

##### Example use :

```php
use \PowerTools\Event_Emitter as Event_Emitter;

// Define some event handlers
$eventHandlers = [
    'handler1' => function($a = '', $b = '') {
        //   var_dump($this);
        echo 'handler1 fired with parameters "' . $a . '" and "' . $b . '"<br />';
    }, 'handler2' => function($a = '', $b = '') {
        //   var_dump($this);
        echo 'handler2 fired with parameters "' . $a . '" and "' . $b . '"<br />';
    }, 'handler3' => function($a = '', $b = '') {
        //   var_dump($this);
        echo 'handler3 fired with parameters "' . $a . '" and "' . $b . '"<br />';
    }, 'handler4' => function($a = '', $b = '') {
        //   var_dump($this);
        echo 'handler4 fired with parameters "' . $a . '" and "' . $b . '"<br />';
    }
];

// Create an instance of the Event_Emitter class
$emitter = Event_Emitter::factory();

// Add your event handlers to your Event_Emitter instance for the 'go' event.
$emitter->addListeners('go', $eventHandlers);

// Emit the 'go' event, with parameters 'FOO' and 1.
$emitter->emit('go', 'FOO', 1);

// Remove the second event handler for the 'go' event
$emitter->removeListener('go', $eventHandlers['handler2']);

// Remove ALL listeners for the 'go' event
$emitter->removeAllListeners('go');
```

-----

##### Supported methods :

- [x] [addListener](https://nodejs.org/api/events.html#events_emitter_addlistener_event_listener)
- [x] addListeners
- [x] [once](https://nodejs.org/api/events.html#events_emitter_once_event_listener)
- [x] [removeListener](https://nodejs.org/api/events.html#events_emitter_removelistener_event_listener)
- [x] removeListeners
- [x] [removeAllListeners]https://nodejs.org/api/events.html#events_emitter_removealllisteners_event)
- [x] [setMaxListeners](https://nodejs.org/api/events.html#events_emitter_setmaxlisteners_n)
- [x] [getMaxListeners](https://nodejs.org/api/events.html#events_emitter_getmaxlisteners)
- [x] [listeners](https://nodejs.org/api/events.html#events_emitter_listeners_event)
- [x] [emit](https://nodejs.org/api/events.html#events_emitter_emit_event_arg1_arg2)
- [x] [listenerCount](https://nodejs.org/api/events.html#events_emitter_listenercount_type)
- [x] [dispatch](https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/dispatchEvent)

-----

##### Author

| [![twitter/johnslegers](https://en.gravatar.com/avatar/bf4cc94221382810233575862875e687?s=70)](http://twitter.com/johnslegers "Follow @johnslegers on Twitter") |
|---|
| [John slegers](http://www.johnslegers.com/) |

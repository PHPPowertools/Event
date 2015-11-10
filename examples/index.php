<?php
define("LOCAL_PATH_BOOTSTRAP", __DIR__);
require LOCAL_PATH_BOOTSTRAP . DIRECTORY_SEPARATOR . 'bootstrap.php';

use \PowerTools\Event_Emitter as Event_Emitter;

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

$emitter1 = Event_Emitter::factory();
$emitter1->addListeners('go', $eventHandlers);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo REQUEST_PROTOCOL . HTTP_PATH_ASSET_CSS; ?>/cascade-full.min.css" />
        <link rel="stylesheet" type="text/css" media="all"  href="<?php echo REQUEST_PROTOCOL . HTTP_PATH_ASSET_CSS; ?>/site.css" />
        <title>PHP PowerTools Boilerplate</title>
        <meta name="description" content="Boilerplate for PHP PowerTools projects">
        <link rel="shortcut icon" href="<?php echo REQUEST_PROTOCOL . HTTP_PATH_ASSET_IMG; ?>/favicon.ico" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="site-header">
            <div class="site-center">
                <div class="cell">
                    <h1>PHP PowerTools Boilerplate</h1>
                </div>
            </div>
        </div>
        <div class="site-body">
            <div class="site-center">
                <div class="cell">
                    <span class="center icon icon-globe icon-64"></span>
                    <p>This is a list of user defined constants for the Boilerplate project.</p>
                    <pre><?php
                               $emitter1->emit('go', 'FOO', 1);
                               $emitter1->removeListener('go', $eventHandlers['handler2']);
                               $emitter1->emit('go', 'FOOT', 2);
                               $emitter1->removeListeners('go', $eventHandlers);
                               $emitter1->emit('go', 'THIRD', 3);

                          ?></pre>
                </div>
            </div>
        </div>
        <div class="site-footer">
            <div class="site-center" id="site-footer-content">
                <div class="col">
                    <div class="cell pipes">
                        <ul class="nav">
                            <li>Powered by <a target="_blank" href="http://www.johnslegers.com">Cascade Framework</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo REQUEST_PROTOCOL . HTTP_PATH_ASSET_JS; ?>/app.js"></script>
    </body>
</html>

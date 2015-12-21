<?php
/*
 * This file is part of the Pulse package.
 *
 * (c) Ferdinand Martin <info@pulseframework.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * ************** CAUTION **************
 *
 * IF YOU WANT TO EDIT THIS FILE set false overwrite files in control
 *
 * ************** CAUTION **************
 */

// @Route(GET)
$API->get('/', 
    function() use($API) {
        // Optional: define a menu father
        pathActive('/');
        // replace this example code with whatever you need
        $API->render('Default:home', array(
            'title' => 'Welcome to PULSE!'
        ));
    }
);

// @Route(GET) Hello World example.
$API->get('/hello/:var', 
    function($var) use($API) {
        // Optional: define a menu father
        pathActive('/hello');
        // replace this example code with whatever you need
        $API->render('Hello:world', array(
            'title' => 'Hello World!',
            'example' => $var
        ));
    }
);

// @Route(POST)
$API->post(
    '/post', 
    function () {
        echo 'This is a POST route';
    }
);

// @Route(PUT)
$API->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// @Route(PATH)
$API->patch(
    '/patch', 
    function () {
        echo 'This is a PATCH route';
    }
);

// @Route(DELETE)
$API->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

// @URIs External URL definition
setUri('documentationUrl','http://doc.pulseframework.com');
setUri('communityUrl','http://doc.pulseframework.com');
setUri('tutosUrl','http://doc.pulseframework.com');

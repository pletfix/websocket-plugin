<?php

return [

    /**
     * --------------------------------------------------------------------------------------------
     * Web Socket Default Port
     * --------------------------------------------------------------------------------------------
     *
     * Default port on which the React Socket Server will listen for incoming connections. You can
     * also define a port in the console command, if nothing is set there, we'll use this port.
     */

    'port' => 1111,

    /**
     * --------------------------------------------------------------------------------------------
     * Port for push messages
     * --------------------------------------------------------------------------------------------
     *
     * This is used for the communication between web server and web socket server.
     */

    'push_port' => 5555,

    /**
     * --------------------------------------------------------------------------------------------
     * ZMQ socket push persistent id
     * --------------------------------------------------------------------------------------------
     *
     * You should make it unique with environment if there are multi environment on your server.
     * For more details see http://php.net/manual/de/zmqcontext.getsocket.php
     */

    'zmq_push_id' => 'zmq.push',

    /**
     * --------------------------------------------------------------------------------------------
     * ZMQ socket pull persistent id
     * --------------------------------------------------------------------------------------------
     *
     * You should make it unique with environment if there are multi environment on your server.
     * For more details see http://php.net/manual/de/zmqcontext.getsocket.php
     */

    'zmq_pull_id' => 'zmq.pull',

];

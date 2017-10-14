# Web Socket for Pletfix

## About This

This plugin provides a smart web socket solution. It's based on [Ratchet](http://socketo.me/), a PHP library to build  
web socket server.

## Supported Browser

- Chrome
- IE 10 and above
- Firefox
- Safari
- Opera
- iOS Safari
- Android Browser 4.4 and above
- Chrome for Android

## Requirements

[ZeroMQ](http://zeromq.org/bindings:php) is require to push messages from web server to the clients.

## Installation

Fetch the package by running the following terminal command under the application's directory:

    composer require pletfix/websocket

After downloading, enter this command in your terminal to register the plugin:

    php console plugin pletfix/websocket

## Configuration
    
By default the TCP port 1111 is used for the web socket and 5555 to push messages.
You may open the configuration file `./config/websocket.php` under the application's directory and override the 
defaults, if you have a port conflict on your system.

## Usage

### Start the Web Socket Server

![Screenshot Server](https://raw.githubusercontent.com/pletfix/websocket-plugin/master/screenshot_server.png)
    
Start the web socket server via shell:

```bash
php console websocket:serve
```
   
Of course, you can run the process in the background like this:

```bash
php console websocket:serve > /dev/null 2>&1 &
```
    
### Web Socket Example
    
![Screenshot Example](https://raw.githubusercontent.com/pletfix/websocket-plugin/master/screenshot_example.png)
    
First, to be able to call the example, add this route entries into `boot/routes.php`:
   
    $router->get('websocket/chat', 'WebSocketController@chat');
    $router->get('websocket/push', 'WebSocketController@push');
    
> Note, that the routes are deliberately has not installed by the registration procedure, because that are only needed 
> for the example. Don't forget to remove the routes when you no longer need the example.
        
Call the example via browser (preferably with two so that you can send messages back and forth :-)   

```http
https://<your-application>/websocket/chat
```

You can push the current time from the web server to the clients with this URL:

```http
https://<your-application>/vendor/pletfix/websocket/push
```

### Web Socket Service 
    
You can use the `websocket()` function to push a message from the web server to the web socket server:
       
    websocket()->push('Hello World');
    
## Customize

### Web Socket Server

To add your own behavior to your web socket, create a web socket handler that implements the interface 
`Pletfix\WebSocket\Handler\Contracts\WebSocketHandler`. A good place for your handler is the `app/Handler` folder.

For a quick start look at the example `vendor/pletfix/websocket-plugin/src/Handler/WebSocketHandler.php`.

After then, add an entry "websocket-handler" into `boot/services.php` to inject your handler into the dependency container.
For example, if the class name of your handler is `\App\Handler\WebSocketHandler`, add the following entry:
 
    $di->set('websocket-handler', \App\Handler\WebSocketHandler::class, true);

### Web Socket Client

Copy the view `vendor/pletfix/websocket-plugin/views/chat.blade.php` to `resources/view/websocket/chat.blade.php`, 
where you can modify the view as you wish.

# Web Socket for Pletfix

## About This

This plugin provides a web socket service.

## Installation 

Fetch the package by running the following terminal command under the application's directory:

    composer require pletfix/websocket-plugin

After downloading, enter this command in your terminal to register the plugin:

    php console plugin pletfix/websocket-plugin 

## Environment and Configuration
    
Add the following environment variables in your `.env` file:
  
    WEBSOCKET_PORT=YourPort

At the next, open the configuration file `./config/websocket.php` under the application's directory and override the 
defaults if you wish.
   
## Customize

### View

If you would like to modified the views of the plugin, create a folder `websocket` under the view directory of the 
application, and copy the views there. Here you can edit the views as you like:
    
    mkdir ./resources/views/websocket 
    cp -R ./vendor/pletfix/websocket-plugin/views/* ./resources/views/websocket

If you have installed the [Pletfix Application Skeleton](https://github.com/pletfix/app), you could add the necessary 
menu items ("client" and "server") by including the partial `_nav` in your `resources/views/app.blade.php` layout just 
above the marker `{{--menu_point--}}`: 
    
    @include('websocket._nav')

### Routes
           
If you like to use another route paths, copy the route entries from `./vendor/pletfix/websocket-plugin/boot/routes.php` 
into the application's routing file `./boot/routes.php`, where you can modify them as you wish:

    $router->get('websocket/client', 'WebSocketController@showClient');
    $router->get('websocket/server', 'WebSocketController@showServer');
 
## Usage

Enter the following URL into your Browser to open the client view:

    https://<your-application>/websocket/client

![Screenshot1](https://raw.githubusercontent.com/pletfix/websocket-plugin/master/screenshot_client.png)

Enter the following URL into your Browser to open the server view:

    https://<your-application>/websocket/server

![Screenshot1](https://raw.githubusercontent.com/pletfix/websocket-plugin/master/screenshot_server.png)
 
### Web Socket Service

#### Accessing the Web Socket service

You can get an instance of the web socket service from the Dependency Injector:

    /** @var Pletfix\WebSocket\Services\Contracts\WebSocket $websocket */
    $websocket = DI::getInstance()->get('websocket');
    
You can also use the `websocket()` function to get the web socket service, it is more comfortable:
       
    $websocket = websocket();

#### Available Methods

#### `dummy()`

This is just a dummy function.

    $dummy = $websocket->dummy();


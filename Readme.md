# Chat app

A simple chat application written in php. This application uses its own framework that is written for this application.


## Application setup

Run the setup. The setup creates the database.db file (or other sepcified in the config). Also it executes all the queries under the sql direcotry.

> Be sure to execute this in the root directory of the project

```php
php setup.php
```

## Api Routes

Authenticated routes needs a token which can be retrived while creating a user or authenticating a user. 

For passing the token you need to add a header as the following:

| HEADER            | Value |
| ------------------|-------|
| Authentication    | TOKEN |


Here are all the api routes:

| Route                 | Description           |  Method       | Authenticated | Post Body                                         |
| ----------------------|-----------------------|---------------|---------------|---------------------------------------------------|
| /user                 | Creates a user        | POST          | FALSE         | {"username": "USERNAME", "password", "PASSWORD"}  |
| /authenticate         | Authenticates a user  | POST          | FALSE         | {"username": "USERNAME", "password", "PASSWORD"}  |
| /user                 | Gets authenticated user | GET         | TRUE          |                                                   |
| /chat                 | Gets chat of user     | GET           | TRUE          |                                                   |
| /chat                 | Creates a chat        | POST          | TRUE          | {"username": "USERNAME_OF_RECIPIENT"}             |
| /chat/:id             | Gets a single chat    | GET           | TRUE          |                                                   |
| /chat/:id             | Deletes a chat        | DELETE        | TRUE          |                                                   |
| /chat/:id/message     | Get messages of chat  | GET           | TRUE          |                                                   |
| /chat/:id/message     | New chat message      | POST          | TRUE          | {"message": "CHAT_MESSAGE"}                       |


## Configuring the application

All configuration is loaded and passed to the kernel in the public/index.php . Here you can add at a later stage other configuration files which are loaded automatically in the container under the key config.

The chat application uses configuration files for the following things

| File                  | Configuration                                                               |
| ----------------------|-----------------------------------------------------------------------------|
| config/Database.php   | Database url configuration (only sqlite database allowed)                   |
| config/Middleware.php | A array of middlewares which will be executed before a controller is loaded |
| config/Routes.php     | A array of routes in the application (see the router)                       |
| config/Validation/*   | Here you can define custom validation domains (see the validator)           |

## The Container

The container is a easy way to share configuration or classes throughout the application. Adding something to the container is easy and can be done in any file. The kernel registers all the base services and should be the go to file for adding new classes / config.

However in some cases adding data on runtime is needed. Like the Middleware/AuthenticationMiddleware which is setting the user in the container for later use for authenticated routes.

The container is stored in a singleton design pattern class which is created in the JeroenFrenken\Chat\Core\Container\Container class. All clases can use the ContainerAwareTrait to make the container available in the specific class. Please note that extending the BaseController already gives access to the container. This also the case with the AbstractMiddleware class.

## The Router

The router is a easy way to load controllers based on a route. Also the router has support for router parameters / method based routing. 

Adding a route is easy but you should stick to the following configuration.

| Key         | Type    | Example                                       |
| ------------|---------|-----------------------------------------------|
| url         | string  | The url that needs the matched (ex: /user)    |
| controller  | string  | The controller (ex: NamespaceController::method) |
| methods     | array   | Array of supported methods                    |
| auth        | bool    | User needs to be authenticated                |


> If you want to access current route information in the controller you can simply access "current_route" in the container

## The Validator

The validator can be used to autmoatically validate data and return messages to the user. Adding propertys to the validator is easy and can be done in this format.

| Key         | Type    | Example                                       |
| ------------|---------|-----------------------------------------------|
| ARRAY_KEY   | string  | The property name (ex: )                      |
| regex       | string  | The regex for validating the property         |
| message     | string  | Message that is returned to user if property is false validated |
| required    | bool    | Required to be send to the validator          |

The validator supports also a function callback for validation. This can be done as the following:

```php
<?php

return [
    'username' => [
        'message' => "Username not valid",
        'required' => true,
        // Please note that a function is only allowed when no regex is presented
        'function' => function($value): bool {
            return false;
        }
    ],
];
```


## Middlewares

A Middleware can be configured in the config/Middleware.php . You only have to pass NamespaceController. Please note that all Middlewares should extend the JeroenFrenken\Chat\Core\Middleware\AbstractMiddleware class. This provides the container in the Middleware and also forces the handle method which is by default called by the Middlewareloader.

## Response Classes

All Controllers Should return a new instance of a Response class. Also Middlewares can return a Response to interupt further loading of the controller. A JsonResponse is also a valid instance of Response because a JsonResponse extends a Response class.

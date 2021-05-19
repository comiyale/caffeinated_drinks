<?php

use App\CaffeinatedMenu;
use App\Http\Controllers;


/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => 'cors','prefix' => 'apiv1'], function () use ($router) {
    $router->get('getMenu',  ['uses' => 'CaffeinatedMenuController@getMenu']);
    $router->get('getItem/{id}', ['uses' => 'CaffeinatedMenuController@getItem']);
    $router->get('consumeItem/{id}/{quantity}', ['uses' => 'CaffeinatedMenuController@consumeItem']);
    $router->put('createItem', ['uses' => 'CaffeinatedMenuController@createItem']);
    $router->patch('updateItem', ['uses' => 'CaffeinatedMenuController@updateItem']);
    $router->delete('deleteItem/{id}', ['uses' => 'CaffeinatedMenuController@deleteItem']);
});

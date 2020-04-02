<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
$router->group(
    [
        'middleware' => 'auth',
        'prefix' => '/'
    ],
    function () use ($router) {
        $router->get('/home', 'HomeController@index');

        require 'web/users.routes.php';
        require 'web/roles.routes.php';
    }
);

<?php
$router->get('/users/{id}/edit', 'UserController@edit');
$router->patch('/users/{id}', 'UserController@update');
$router->put('/users/{id}', 'UserController@update');

// Users
$router->group(
    [
        'prefix' => 'users',
        'middleware' => 'permission:view.users',
    ]
    , function () use ($router) {
    $router->get('', ['as' => 'users.index', 'uses' => 'UserController@index']);
    $router->post('', ['as' => 'users.store', 'uses' => 'UserController@store'])
        ->middleware('permission:create.users');
    $router->get('/create', ['as' => 'users.create', 'uses' => 'UserController@create'])
        ->middleware('permission:create.users');
    $router->put('/{user}', ['as' => 'users.update', 'uses' => 'UserController@update'])
        ->middleware('permission:edit.users');
    $router->patch('/{user}', ['as' => 'users.update', 'uses' => 'UserController@update'])
        ->middleware('permission:edit.users');
    $router->delete('/{user}', ['as' => 'users.destroy', 'uses' => 'UserController@destroy'])
        ->middleware('permission:delete.users');
    $router->get('/{user}', ['as' => 'users.show', 'uses' => 'UserController@show']);
    $router->get('/{user}/edit', ['as' => 'users.edit', 'uses' => 'UserController@edit'])
        ->middleware('permission:edit.users');
});

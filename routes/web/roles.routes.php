<?php
// roles
$router->group(
    [
        'prefix' => 'roles',
        'middleware' => 'permission:roles.view',
    ],
    function () use ($router) {
        $router->get(
            '',
            [
                'as' => 'roles.index',
                'uses' => 'RoleController@index'
            ]
        );
        $router->post(
            '',
            [
                'as' => 'roles.store',
                'uses' => 'RoleController@store'
            ]
        )
            ->middleware('permission:roles.create');
        $router->get(
            '/create',
            [
                'as' => 'roles.create',
                'uses' => 'RoleController@create'
            ]
        )
            ->middleware('permission:roles.create');
        $router->put(
            '/{roles}',
            [
                'as' => 'roles.update',
                'uses' => 'RoleController@update'
            ]
        )
            ->middleware('permission:roles.edit');
        $router->patch(
            '/{roles}',
            [
                'as' => 'roles.update',
                'uses' => 'RoleController@update'
            ]
        );
        $router->delete(
            '/{roles}',
            [
                'as' => 'roles.destroy',
                'uses' => 'RoleController@destroy'
            ]
        )
            ->middleware('permission:roles.delete');
        $router->get(
            '/{roles}',
            [
                'as' => 'roles.show',
                'uses' => 'RoleController@show'
            ]
        );
        $router->get(
            '/{roles}/edit',
            [
                'as' => 'roles.edit',
                'uses' => 'RoleController@edit'
            ]
        )
            ->middleware('permission:roles.edit');
    }
);

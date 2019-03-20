<?php

/**
 * AUTH.
 */
Route::get('logout', ['as' => 'get.logout', 'uses' => 'AuthController@getLogout']);
Route::get('login', ['as' => 'get.login', 'uses' => 'AuthController@getLogin']);
Route::post('login', ['as' => 'post.login', 'uses' => 'AuthController@postLogin']);
Route::get('register', ['as' => 'get.register', 'uses' => 'RegisterController@showRegistrationForm']);
Route::post('register', ['as' => 'post.register', 'uses' => 'RegisterController@register']);

/*
 * PASSWORD RESET
 */
Route::group(['prefix' => 'password'], function () {
    Route::get('email', ['as' => 'get.password.email', 'uses' => 'PasswordController@getEmail']);
    Route::post('email', ['as' => 'post.password.email', 'uses' => 'PasswordController@postEmail']);
    Route::get('reset', ['as' => 'get.password.reset', 'uses' => 'PasswordController@getReset']);
    Route::post('reset', ['as' => 'post.password.reset', 'uses' => 'PasswordController@postReset']);
});

/*
 * ADMIN - GROUPS
 */
Route::group(['prefix' => 'admin/groups'], function () {

    //---# INDEX
    Route::get('/', [
        'as'          => 'get.groups',
        'uses'        => 'GroupsController@getIndex',
        'middleware'  => 'allow.only',
        'permissions' => ['groups.list'],
    ]);

    //---# CREATE
    Route::get('create', [
        'as'          => 'get.groups.create',
        'uses'        => 'GroupsController@getCreate',
        'middleware'  => 'allow.only',
        'permissions' => ['groups.create'],
    ]);
    Route::post('create', [
        'as'          => 'post.groups.create',
        'uses'        => 'GroupsController@postCreate',
        'middleware'  => 'allow.only',
        'permissions' => ['groups.create'],
    ]);

    //---# EDIT
    Route::get('{id}', [
        'as'          => 'get.groups.edit',
        'uses'        => 'GroupsController@getEdit',
        'middleware'  => 'allow.only',
        'permissions' => ['groups.edit'],
    ]);
    Route::post('{id}', [
        'as'          => 'post.groups.edit',
        'uses'        => 'GroupsController@postEdit',
        'middleware'  => 'allow.only',
        'permissions' => ['groups.edit'],
    ]);

    //---# DELETE
    Route::get('{id}/delete', [
        'as'          => 'get.groups.delete',
        'uses'        => 'GroupsController@getDelete',
        'middleware'  => 'allow.only',
        'permissions' => ['groups.delete'],
    ]);
});

/*
 * ADMIN - USERS
 */
Route::group(['prefix' => 'admin/users'], function () {

    //---# INDEX
    Route::get('/', [
        'as'          => 'get.users',
        'uses'        => 'UsersController@getIndex',
        'middleware'  => 'allow.only',
        'permissions' => ['users.list'],
    ]);

    //---# CREATE
    Route::get('create', [
        'as'          => 'get.users.create',
        'uses'        => 'UsersController@getCreate',
        'middleware'  => 'allow.only',
        'permissions' => ['users.create'],
    ]);
    Route::post('create', [
        'as'          => 'post.users.create',
        'uses'        => 'UsersController@postCreate',
        'middleware'  => 'allow.only',
        'permissions' => ['users.create'],
    ]);

    //---# EDIT
    Route::get('{id}', [
        'as'          => 'get.users.edit',
        'uses'        => 'UsersController@getEdit',
        'middleware'  => 'allow.only',
        'permissions' => ['users.edit'],
    ]);
    Route::post('{id}', [
        'as'          => 'post.users.edit',
        'uses'        => 'UsersController@postEdit',
        'middleware'  => 'allow.only',
        'permissions' => ['users.edit'],
    ]);

    //---# DELETE
    Route::any('{id}/delete', [
        'as'          => 'get.users.delete',
        'uses'        => 'UsersController@getDelete',
        'middleware'  => 'allow.only',
        'permissions' => ['users.delete'],
    ]);
});

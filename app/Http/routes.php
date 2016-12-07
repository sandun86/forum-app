<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/
//disable throttle
Sentinel::disableCheckpoints();

Route::resource('user', 'API\v1\UserController', ['except' => 'destroy']);
Route::post('user/login', 'API\v1\UserController@userLogin');
Route::post('user/logout', 'API\v1\UserController@logout');

Route::group(['middleware' => 'validateToken'], function () {
	Route::resource('post', 'API\v1\PostController', ['only' => [
    	'store', 'destroy', 'update'
	]]);
});

Route::resource('post', 'API\v1\PostController', ['only' => [
	'index'
]]);

Route::get('post/create', 'API\v1\PostController@getPost');
Route::get('post/my-posts', 'API\v1\PostController@getOwnPosts');
Route::get('post/edit-post/{id}', 'API\v1\PostController@getEditPost');


Route::get('/', function () {
	return redirect('/post');
});


Route::resource('admin/users', 'Admin\UserController', ['only' => [
		'index'
	]]);

Route::get('admin/login', 'Admin\AdminUserController@getLogin');
Route::post('admin/logout', 'Admin\AdminUserController@postLogout');
Route::post('admin/login', 'Admin\AdminUserController@postLogin');
Route::get('admin/dashboard', 'Admin\AdminUserController@getDashboard');

Route::get('admin/post/create', 'Admin\PostController@getPost');
Route::get('admin/post/edit-post/{id}', 'Admin\PostController@getEditPost');

Route::get('admin/user/create', 'Admin\UserController@getUser');
Route::get('admin/user/edit-user/{id}', 'Admin\UserController@getEditUser');

Route::group(['middleware' => 'adminTokenValidator'], function () {
	Route::resource('admin/post', 'Admin\PostController', ['only' => [
		'store', 'destroy', 'update'
	]]);

	Route::resource('admin/users', 'Admin\UserController', ['only' => [
		'update', 'destroy', 'store'
	]]);

});

Route::resource('admin/post', 'Admin\PostController', ['only' => [
	'index'
]]);




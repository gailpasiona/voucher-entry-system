<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
// Confide routes
Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');
Route::get( 'setup/group/create',          'GroupController@create');
Route::post('setup/group',                 'GroupController@save');
Route::get( 'setup/group/perm',            'GroupController@add_permission');
Route::get( 'setup/group/assign',          'GroupController@attach_user');
Route::get('setup/permission/create',      'PermissionController@create');
Route::post('setup/permission',            'PermissionController@save');
Route::get('setup/business_partner/create','BusinessPartnerController@create');
Route::post('setup/business_partner',      'BusinessPartnerController@save');
Route::get('voucher/create',         'VoucherController@create');
Route::post('voucher',                     'VoucherController@save');


//print sql statements
//Event::listen('illuminate.query', function($query)
//{
//    var_dump($query);
//});
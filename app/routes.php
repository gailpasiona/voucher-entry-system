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
	return View::make('layouts.dashboard');
});
// Confide routes
Route::get( 'user/create',                 array('as' => 'signup', 'uses' => 'UserController@create'));
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
Route::post('setup/group/attach',          'GroupController@update_user_role');
Route::get('setup/permission/create',      'PermissionController@create');
Route::post('setup/permission',            'PermissionController@save');
Route::get('setup/business_partner/create','BusinessPartnerController@create');
Route::get('setup/business_partner/list','BusinessPartnerController@listrecords');
Route::get('setup/business_partner/ajax','BusinessPartnerController@popTable');
Route::get('setup/business_partner/modify/{name}', array('as' => 'modifyBP', 'uses' => 'BusinessPartnerController@modify'));
Route::get('setup/business_partner/create2', array('as' => 'createBP', 'uses' => 'BusinessPartnerController@create2'));
Route::post('setup/business_partner/add',      'BusinessPartnerController@saves');
Route::post('setup/business_partner/update', 'BusinessPartnerController@update');
Route::get('voucher/create',               'VoucherController@create');
Route::post('voucher/add',                     'VoucherController@saves');
Route::get('voucher/list',               'VoucherController@edit');
Route::get('voucher/ajax',               'VoucherController@popTable');

Route::get('voucher/create2', array('as' => 'createVoucher', 'uses' => 'VoucherController@create2'));

Route::get('voucher/approval/{name}', array('as' => 'approveVoucher', 'uses' => 'VoucherController@approve'));
Route::post('voucher/approve', array('as' => 'approvesVoucher', 'uses' => 'VoucherController@signatory'));
Route::post('voucher/reactivate', array('as' => 'reopenVoucher', 'uses' => 'VoucherController@reactivate'));
Route::get('voucher/modify/{name}', array('as' => 'modifyVoucher', 'uses' => 'VoucherController@modify'));
Route::post('voucher/update',               'VoucherController@update');
Route::post('voucher/updates', array('as' => 'updateVoucher', 'uses' => 'VoucherController@updates'));
Route::post('voucher/attachment/{name}', array('as' => 'attachVoucher', 'uses' => 'VoucherController@attachment'));

Route::get('voucher/report', array('as' => 'voucherReports', 'uses' => 'VoucherController@reporting'));
Route::any('voucher/get_report', array('as' => 'getRepors', 'uses'=> 'VoucherController@getReport'));
Route::any('voucher/more_info/{voucher}', array('as' => 'getDetail', 'uses'=> 'VoucherController@getReportDetails'));
Route::any('voucher/receipts', array('as' => 'getRec', 'uses'=> 'VoucherController@receipt'));
Route::any('voucher/detailed_report', array('as' => 'getDetailed', 'uses' => 'VoucherController@getDetailed'));
Route::post('voucher/receipts/post', array('as' => 'postRec', 'uses' => 'VoucherController@post_receipt'));
//print sql statements
//Event::listen('illuminate.query', function($query)
//{
//    var_dump($query);
//});
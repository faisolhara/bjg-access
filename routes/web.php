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
Route::get('/','AuthController@cekStatus');
Route::get('/login','AuthController@index');
Route::post('/post-login','AuthController@postLogin');

Route::group(['middleware' => ['customAuth', 'menu']], function(){
	Route::get('/logout','AuthController@logout');
	
	Route::group(['prefix' => 'access-control'], function(){
		Route::any('/','AccessControlController@index');
		Route::get('/edit/{username}','AccessControlController@edit');
		Route::post('save','AccessControlController@save');
	});
	
	Route::get('/home','NotificationController@home');

	Route::get('/notification-detail','NotificationController@notificationDetail');
	Route::post('/approve-notification','NotificationController@approveNotification');

	Route::post('/approve-absence','NotificationController@approveAbsence');
	Route::post('/approve-requisition','NotificationController@approveRequisition');
	Route::post('/approve-spkl','NotificationController@approveSpkl');
	Route::post('/approve-quote','NotificationController@approveQuote');

	Route::get('/onhand','OnhandController@index');
	Route::post('/onhand','OnhandController@view');

	Route::get('/onhand2','OnhandController@index2');
	Route::post('/onhand2','OnhandController@view2');

	Route::post('/onhand/get-detail-item','OnhandController@getDetailItem');
	
	Route::group(['prefix' => 'absence'], function(){
		Route::any('/','AbsenceController@index');
		Route::get('/detail','AbsenceController@detail');

	});

	Route::group(['prefix' => 'birthday'], function(){
		Route::any('/','BirthdayController@index');

	});

	Route::group(['prefix' => 'purchasing'], function(){
		Route::group(['prefix' => 'my-requisition'], function(){
			Route::any('/', 'Purchasing\MyRequisitionController@index');
			Route::any('/detail','Purchasing\MyRequisitionController@detail');
		});
	});

});


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

// หน้าแรก
Route::get('/', 'IndexController@index')->name('index');

// index dts
Route::get('/dataset', 'DatasetController@index');

// ajax index
Route::post('/list-data', 'IndexController@list_data');

// หน้า แรก new
Route::get('/dataset/new', 'DatasetController@new');

// รับค่าจาก new มายัดลง session
Route::post('/dataset/pre_new_resource','DatasetController@pre_new_resource');

// หน้าตอจาก new เอา session มาใช้
Route::get('/dataset/new_resource', 'DatasetController@new_resource');

// สำหรับ save resource ปกติ
Route::post('/dataset/save', 'DatasetController@save');

// หน้า detail แต่ละ dts
Route::get('/dataset/page/{slug}', 'DatasetController@page');

// หน้า edit แต่ละ dts
Route::get('/dataset/edit/{slug}', 'DatasetController@edit');

// อัพเดต dts
Route::put('/dataset/update', 'DatasetController@update');

// ปรับสถานะ dts
Route::post('/dataset/set_status', 'DatasetController@set_status');

// ลบ dts
Route::delete('/dataset/delete/{slug}', 'DatasetController@delete');

////////////////////////////////////////////////////////////////////////////////////

// preivew res ของ data set
Route::get('/dataset/page/{slug}/resource/{res_slug}', 'ResourceController@preview');

// สำหรับเพิ่ม res ใหม่
Route::get('/resource/new_resource/{slug}', 'ResourceController@add_new_resource');

// สำหรับ save res ใหม่
Route::post('/resource/save', 'ResourceController@save');

// edit res
Route::get('/dataset/page/{slug}/resource_edit/{res_slug}', 'ResourceController@edit');

// update res
Route::put('/resource/update', 'ResourceController@update');

// ลบ res
Route::delete('/resource/delete/{res_id}', 'ResourceController@delete');

////////////////////////////////////////////////////////////////////////////////////

// index ogz
Route::get('/organization', 'OrganizationController@index');

// หน้า new ogz
Route::get('/organization/new', 'OrganizationController@new');

// save new ogz
Route::post('/organization/save', 'OrganizationController@save');

// หน้า detail แต่ละ ogz
Route::get('/organization/page/{slug}', 'OrganizationController@page');

// หน้า edit แต่ละ ogz
Route::get('/organization/edit/{slug}', 'OrganizationController@edit');

// อัพเดต ogz
Route::put('/organization/update', 'OrganizationController@update');

// ลบ ogz
Route::delete('/organization/delete/{slug}', 'OrganizationController@delete');

/////////////////////////////////////////////////////////////////////////

Route::resource('administrator', 'AdministratorController');

//////////////////////////////////////////////////////////////////////////////

Route::resource('categories', 'CategoriesController');

//////////////////////////////////////////////////////////////////////////////

Route::get('/login', 'IndexController@login');
Route::post('/chk_login', 'IndexController@chk_login');
Route::get('/logout', function () {
    return redirect('/')->withCookie(Cookie::forget('token'));
});

Route::get('/is-login', 'IndexController@is_login');
Route::post('/user-download', 'IndexController@user_download');

// Route::post('/list-user', 'IndexController@list_user');

// Route::get('/cookie', function () {
//     dd(Cookie::get('token'));
// });
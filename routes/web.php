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
Route::get('/env',function(){
    if (App::environment('local')) {
        phpinfo();
    }
});

// หน้าแรก
// Route::get('/', 'DatasetController@index')->name('index');

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

// ลบ metadata
Route::get('/dataset/delete_metadata/{mtd_id}', 'DatasetController@delete_metadata');

Route::post('/dataset/update_metadata', 'DatasetController@update_metadata');

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
Route::get('/', 'OrganizationController@index');
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

// Data management
Route::resource('/datamanagement', 'DatamanagementController');
Route::post('/datamanagement/export/{id}', 'DatamanagementController@export');
//////////////////

Route::resource('administrator', 'AdministratorController');

// api metadata
Route::get('/get_matadata/{dts_id}', 'DatasetController@view_metadata');

// Mass admin
Route::get('/api/mass-admin', 'IndexController@mass_admin');

///////////////////////////////////////////////

Route::resource('categories', 'CategoriesController');

//////////////////////////////////////////////////////////////////////////////

Route::get('/login', 'IndexController@login');
Route::post('/chk_login', 'IndexController@chk_login');
Route::get('/logout', function () {
    return redirect('/')->withCookie(Cookie::forget('token'))
    ->withCookie(Cookie::forget('m_type'))->withCookie(Cookie::forget('m_ogz'));
});

// Check login
Route::get('/is-login', 'IndexController@is_login');

// Check username
Route::post('/is-exists', 'IndexController@is_exists');

// Add Log Download
Route::post('/user-download', 'IndexController@user_download');

// View Log Download
Route::get('/log-download', 'LogdownloadController@index');

Route::post('/filter-cat', 'IndexController@filter_cat');

Route::post('/filter-ogz', 'IndexController@filter_ogz');

// Route::post('/list-user', 'IndexController@list_user');

// Route::get('/cookie', function () {
//     dd(Cookie::get('token'));
// });

/////////////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/session', function () {
    dd(session('new_dataset'));
});
Route::get('/cookie', function () {
    // \Cookie::forget('USER_FULLNAME');
    // \Cookie::forget('USER_EMAIL');
    dd(\Cookie::get());
});

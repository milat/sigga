<?php

use App\Utils\Friendly;
use Illuminate\Support\Facades\Route;

/**
 *  Guest home
 */
Route::get('/', 'GuestController@login')->name('index');

/**
 *  Login and logout
 */
Route::post('/'.Friendly::get('login'), 'UserController@login')->name('login');
Route::post('/'.Friendly::get('logout'), 'UserController@logout')->name('logout');

/**
 *  Home
 */
Route::get('/'.Friendly::get('home'), 'HomeController@index')->name('home')->middleware('auth');

/**
 *  Superuser
 */
Route::prefix(Friendly::get('superuser'))->name('superuser.')->group(function () {
    Route::get('/', 'SuperuserController@index')->name('index');
    Route::post('/'.Friendly::get('login'), 'SuperuserController@login')->name('login');
    Route::post('/'.Friendly::get('logout'), 'SuperuserController@logout')->name('logout');
});

// Route::get('/admin/', function(){
//     return view('admin.index');
// })->name('dashboard')->middleware('auth:admin');

// Route::get('/admin/gabinetes', function () {
//     return view('admin.gabinete.index');
// })->name('admin.gabinete')->middleware('auth:admin');

/**
 *  User
 */
Route::prefix(Friendly::get('users'))->name('user.')->middleware('auth')->group(function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'UserController@search')->name('search');
    Route::get('/'.Friendly::get('edit').'/{id}', 'UserController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'UserController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'UserController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'UserController@insert')->name('insert');
    Route::get('/'.Friendly::get('password'), 'UserController@password')->name('password');
    Route::put('/'.Friendly::get('password'), 'UserController@passwordAction')->name('password.action');
});

/**
 *  Role
 */
Route::prefix(Friendly::get('roles'))->name('role.')->middleware('auth')->group(function () {
    Route::get('/', 'RoleController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'RoleController@search')->name('search');
    Route::get('/'.Friendly::get('edit').'/{id}', 'RoleController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'RoleController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'RoleController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'RoleController@insert')->name('insert');
    Route::get('/'.Friendly::get('permissions').'/{id}', 'RoleController@permission')->name('permission');
    Route::post('/'.Friendly::get('permissions').'/{id}/'.Friendly::get('update'), 'RoleController@access')->name('access');
});

/**
 *  Citizen
 */
Route::prefix(Friendly::get('citizens'))->name('citizen.')->middleware('auth')->group(function () {
    Route::get('/', 'CitizenController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'CitizenController@search')->name('search');
    Route::get('/'.Friendly::get('edit').'/{id}', 'CitizenController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'CitizenController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'CitizenController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'CitizenController@insert')->name('insert');
});

/**
 *  Document
 */
Route::prefix(Friendly::get('documents'))->name('document.')->middleware('auth')->group(function () {
    Route::get('/', 'DocumentController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'DocumentController@search')->name('search');
    Route::get('/'.Friendly::get('edit').'/{id}', 'DocumentController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'DocumentController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'DocumentController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'DocumentController@insert')->name('insert');
    Route::get('/'.Friendly::get('download').'/{id}', 'DocumentController@download')->name('download');
});

/**
 *  Organization
 */
Route::prefix(Friendly::get('organizations'))->name('organization.')->middleware('auth')->group(function () {
    Route::get('/', 'OrganizationController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'OrganizationController@search')->name('search');
    Route::get('/'.Friendly::get('edit').'/{id}', 'OrganizationController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'OrganizationController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'OrganizationController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'OrganizationController@insert')->name('insert');
});

/**
 *  Category
 */
Route::prefix(Friendly::get('categories'))->name('category.')->middleware('auth')->group(function () {
    Route::get('/', 'RequestCategoryController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'RequestCategoryController@search')->name('search');
    Route::get('/'.Friendly::get('edit').'/{id}', 'RequestCategoryController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'RequestCategoryController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'RequestCategoryController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'RequestCategoryController@insert')->name('insert');
});

/**
 *  Request
 */
Route::prefix(Friendly::get('requests'))->name('request.')->middleware('auth')->group(function() {
    Route::get('/', 'RequestController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'RequestController@search')->name('search');
    Route::get('/'.Friendly::get('view').'/{id}', 'RequestController@view')->name('view');
    Route::put('/'.Friendly::get('view').'/{id}/'.Friendly::get('update'), 'RequestController@update')->name('update');
    Route::post('/'.Friendly::get('view').'/{id}/'.Friendly::get('progress'), 'RequestController@progress')->name('progress');
    Route::post('/'.Friendly::get('view').'/{id}/'.Friendly::get('attachment'), 'RequestController@attachment')->name('attachment');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('attachment').'/'.Friendly::get('download').'/{attachmentId}', 'RequestController@download')->name('download');
    Route::get('/'.Friendly::get('create'), 'RequestController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'RequestController@insert')->name('insert');
});

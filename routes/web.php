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
    Route::get('/'.Friendly::get('search').'/{query?}', 'UserController@search')->name('search')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'UserController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'UserController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'UserController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'UserController@insert')->name('insert');
    Route::get('/'.Friendly::get('password'), 'UserController@password')->name('password');
    Route::put('/'.Friendly::get('password'), 'UserController@passwordAction')->name('password.action');
    Route::get('/'.Friendly::get('view').'/{id}', 'UserController@view')->name('view');
});

/**
 *  Role
 */
Route::prefix(Friendly::get('roles'))->name('role.')->middleware('auth')->group(function () {
    Route::get('/', 'RoleController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'RoleController@search')->name('search')->where('query', '(.*)');
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
    Route::get('/'.Friendly::get('search').'/{query?}', 'CitizenController@search')->name('search')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'CitizenController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'CitizenController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'CitizenController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'CitizenController@insert')->name('insert');
    Route::get('/'.Friendly::get('view').'/{id}', 'CitizenController@view')->name('view');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('dependents'), 'DependentController@index')->name('dependent');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('dependents').'/'.Friendly::get('create'), 'DependentController@create')->name('dependent.create');
    Route::post('/'.Friendly::get('view').'/{id}/'.Friendly::get('dependents').'/'.Friendly::get('insert'), 'DependentController@insert')->name('dependent.insert');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('dependents').'/'.Friendly::get('edit').'/{dependentId}', 'DependentController@edit')->name('dependent.edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('dependents').'/'.Friendly::get('edit').'/{dependentId}'.Friendly::get('update'), 'DependentController@update')->name('dependent.update');
});

/**
 *  Document
 */
Route::prefix(Friendly::get('documents'))->name('document.')->middleware('auth')->group(function () {
    Route::get('/', 'DocumentController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'DocumentController@search')->name('search')->where('query', '(.*)')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'DocumentController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'DocumentController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'DocumentController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'DocumentController@insert')->name('insert');
    Route::get('/'.Friendly::get('download').'/{id}', 'DocumentController@download')->name('download');
    Route::get('/'.Friendly::get('combo'), 'DocumentController@combo')->name('combo');
});

/**
 *  Attachment
 */
Route::prefix(Friendly::get('attachments'))->name('attachment.')->middleware('auth')->group(function () {
    Route::get('/', 'AttachmentController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'AttachmentController@search')->name('search')->where('query', '(.*)')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'AttachmentController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'AttachmentController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'AttachmentController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'AttachmentController@insert')->name('insert');
    Route::get('/'.Friendly::get('download').'/{id}', 'AttachmentController@download')->name('download');
});

/**
 *  Activities
 */
Route::prefix(Friendly::get('activities'))->name('activity.')->middleware('auth')->group(function () {
    Route::get('/', 'ActivityController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'ActivityController@search')->name('search')->where('query', '(.*)')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'ActivityController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'ActivityController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'ActivityController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'ActivityController@insert')->name('insert');
});

/**
 *  Activity classes
 */
Route::prefix(Friendly::get('activity_classes'))->name('activity_class.')->middleware('auth')->group(function () {
    Route::get('/', 'ActivityClassController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'ActivityClassController@search')->name('search')->where('query', '(.*)')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'ActivityClassController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'ActivityClassController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'ActivityClassController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'ActivityClassController@insert')->name('insert');

    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('activity_subscribers').'/', 'ActivitySubscriberController@index')->name('subscriber');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('activity_subscribers').'/'.Friendly::get('search').'/{query?}', 'ActivitySubscriberController@search')->name('subscriber.search')->where('query', '(.*)')->where('query', '(.*)');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('activity_subscribers').'/'.Friendly::get('edit').'/{subId}', 'ActivitySubscriberController@edit')->name('subscriber.edit');
    Route::put('/'.Friendly::get('view').'/{id}/'.Friendly::get('activity_subscribers').'/'.Friendly::get('edit').'/{subId}/'.Friendly::get('update'), 'ActivitySubscriberController@update')->name('subscriber.update');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('activity_subscribers').'/'.Friendly::get('create'), 'ActivitySubscriberController@create')->name('subscriber.create');
    Route::post('/'.Friendly::get('view').'/{id}/'.Friendly::get('activity_subscribers').'/'.Friendly::get('insert'), 'ActivitySubscriberController@insert')->name('subscriber.insert');
});

/**
 *  Organization
 */
Route::prefix(Friendly::get('organizations'))->name('organization.')->middleware('auth')->group(function () {
    Route::get('/', 'OrganizationController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'OrganizationController@search')->name('search')->where('query', '(.*)');
    Route::get('/'.Friendly::get('edit').'/{id}', 'OrganizationController@edit')->name('edit');
    Route::put('/'.Friendly::get('edit').'/{id}/'.Friendly::get('update'), 'OrganizationController@update')->name('update');
    Route::get('/'.Friendly::get('create'), 'OrganizationController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'OrganizationController@insert')->name('insert');
    Route::get('/'.Friendly::get('view').'/{id}', 'OrganizationController@view')->name('view');
});

/**
 *  Category
 */
Route::prefix(Friendly::get('categories'))->name('category.')->middleware('auth')->group(function () {
    Route::get('/', 'RequestCategoryController@index')->name('index');
    Route::get('/'.Friendly::get('search').'/{query?}', 'RequestCategoryController@search')->name('search')->where('query', '(.*)');
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
    Route::get('/'.Friendly::get('search').'/{query?}', 'RequestController@search')->name('search')->where('query', '(.*)');
    Route::get('/'.Friendly::get('view').'/{id}', 'RequestController@view')->name('view');
    Route::put('/'.Friendly::get('view').'/{id}/'.Friendly::get('update'), 'RequestController@update')->name('update');
    Route::post('/'.Friendly::get('link').'/{id}/', 'RequestController@link')->name('link');
    Route::post('/'.Friendly::get('document').'/{id}/', 'RequestController@document')->name('document');
    Route::post('/'.Friendly::get('view').'/{id}/'.Friendly::get('progress'), 'RequestController@progress')->name('progress');
    Route::post('/'.Friendly::get('view').'/{id}/'.Friendly::get('attachment'), 'RequestController@attachment')->name('attachment');
    Route::get('/'.Friendly::get('view').'/{id}/'.Friendly::get('attachment').'/'.Friendly::get('download').'/{attachmentId}', 'RequestController@download')->name('download');
    Route::get('/'.Friendly::get('create'), 'RequestController@create')->name('create');
    Route::post('/'.Friendly::get('insert'), 'RequestController@insert')->name('insert');
    Route::get('/'.Friendly::get('warn'), 'RequestController@warn')->name('warn');
});

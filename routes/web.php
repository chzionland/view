<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


# TODO: For user auth
// # User
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
// Route::post('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');

# Admin
Route::prefix('admin')->group(function () {

    # Dashboard
    Route::get('/', 'AdminController@index')->name('admin.dashboard');

    # Login and Logout
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    # No register, only can add admin in tinker for safe consideration

    # Reset password
    # TODO: need debug
    // Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    // Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    // Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    // Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');

    # CMS
    Route::resource('categories', 'CategoryController');
    Route::resource('authors', 'AuthorController');
    Route::resource('posts', 'PostController');
    Route::resource('pages', 'PageController');
    Route::resource('news', 'NewsController');
    Route::resource('tags', 'TagController');
    Route::resource('photos', 'PhotoController');
});

Route::group(['prefix' => '{locale?}'], function() {

    # Web
    Route::get('/', 'WebsiteController@index')->name('index');
    // Route::get('category/{slug}', 'WebsiteController@category')->name('category');
    Route::get('column/{slug}', 'WebsiteController@column')->name('column');
    Route::get('post/{slug}', 'WebsiteController@post')->name('post');
    Route::get('page/{slug}', 'WebsiteController@page')->name('page');
});




<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', function () {
    return view('backend.login');
})->name('loginView');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// home page
Route::post('/login', 'UserController@login')->name('login');

Route::group(['middleware'=> 'isLogged'], function (){
    Route::get('/dashboard', 'UserController@index')->name('dashboard');
    Route::get('/dashboard/librat', 'LibriController@index')->name('listLibrat');
    Route::get('/dashboard/librat/edito/{id}', 'LibriController@edit')->name('editLibri');
//    Route::get('/dashboard/librat/edito/{id}', 'LibriController@edit')->name('viewLibri');

    Route::group(['middleware'=> 'isPunonjes'], function () {

        Route::get('/dashboard/users', 'LibriController@index')->name('listUsers');

    });
        Route::get('/logout', 'UserController@logout')->name('logout');

});
Route::get('/pass', 'UserController@pass')->name('password');
//
///* Auth */
//Route::controllers([
//    'auth' => 'Auth\AuthController',
//    'password' => 'Auth\PasswordController',
//]);
//
//// about page
//Route::get('/about', function () {
//    return view('frontend.about');
//});
//
//// contact page
//Route::get('/contact', function () {
//    return view('frontend.contact');
//});
//
//// portfolio page
//Route::get('/portfolio', 'PageController@portfolioPage');
//
//// single picture page
//Route::get('/pictures/{id}', 'PageController@singlePicture');
//
//// api orders
//Route::post('/create-order', 'OrderController@createOrder');
//
//

    // admin pages
//    Route::get('/categories', 'AdminController@categories');
//    Route::get('/admin/pictures', 'AdminController@pictures');
//    Route::get('/admin/orders', 'AdminController@orders');
//
//    // api category
//    Route::post('/admin/get-all-categories', 'CategoryController@getAllCategories');
//    Route::post('/create-category', 'CategoryController@store')->name('createCategory');
//    Route::post('/admin/update-category', 'CategoryController@update');
//    Route::post('/admin/delete-category', 'CategoryController@destroy');
//    Route::post('/admin/get-category-by-id', 'CategoryController@getCategoryById');
//    Route::post('/admin/search-category-by-name', 'CategoryController@searchCategoryByName');
//
//    // api picture
//    Route::post('/admin/get-all-pictures', 'PictureController@getAllPictures');
//    Route::post('/admin/create-picture', 'PictureController@store');
//    Route::post('/admin/update-picture', 'PictureController@update');
//    Route::post('/admin/delete-picture', 'PictureController@destroy');
//    Route::post('/admin/get-picture-by-id', 'PictureController@getPictureById');
//    Route::post('/admin/search-picture-by-name', 'PictureController@searchPictureByName');
//
//    // api orders
//    Route::post('/approve-order', 'OrderController@approveOrder');

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
//Route::get('/pass', 'UserController@pass')->name('pass');

Route::group(['middleware'=> 'isLogged'], function (){
    Route::get('/dashboard', 'UserController@index')->name('dashboard');
    Route::get('/dashboard/librat', 'LibriController@index')->name('listLibrat');
    Route::get('/dashboard/librat/krijo', 'LibriController@create')->name('krijoLiber');
    Route::post('/dashboard/librat/krijo/ruaj', 'LibriController@ruaj')->name('ruajLiber');
    Route::get('/dashboard/librat/edito/{id}', 'LibriController@edit')->name('editLibri');
    Route::post('/dashboard/librat/edito/update', 'LibriController@update')->name('updateLiber');
    Route::get('/dashboard/librat/huazo/{id}', 'LibriController@huazo')->name('huazoLiber');


    Route::post('/dashboard/librat/huazo/libri', 'HuazimController@ruajHuazim')->name('huazoLibri');
//    Route::get('/dashboard/librat/edito/{id}', 'LibriController@edit')->name('viewLibri');

    Route::group(['middleware'=> 'isPunonjes'], function () {

        Route::get('/dashboard/users', 'LibriController@index')->name('listUsers');
        Route::get('/dashboard/klient', 'KlientController@index')->name('listKlient');
        Route::get('/dashboard/klient/krijo', 'KlientController@create')->name('krijoKlient');
        Route::post('/dashboard/klient/ruaj', 'KlientController@ruaj')->name('ruajKlient');
        Route::get('/dashboard/klient/shiko/{id}', 'KlientController@view')->name('shikoKlient');
        Route::post('/dashboard/klient/shiko/kthe', 'LibriController@kthe')->name('ktheLibri');

        Route::get('/dashboard/autor', 'AutorController@index')->name('listAutor');
        Route::get('/dashboard/autor/krijo', 'AutorController@create')->name('krijoAutor');
        Route::post('/dashboard/autor/ruaj', 'AutorController@ruaj')->name('saveAutor');
        Route::get('/dashboard/autor/shiko/{id}', 'AutorController@view')->name('shikoAutor');
        Route::post('/dashboard/autor/fshi', 'AutorController@fshi')->name('fshiAutor');


        Route::post('/dashboard/zhaner/fshi', 'ZhanriController@fshi')->name('fshiZhaner');
        Route::post('/dashboard/zhaner/krijo', 'ZhanriController@save')->name('save_zhaner');
        Route::get('/dashboard/zhaner', 'ZhanriController@view')->name('viewZhaner');


        Route::get('/dashboard/mesazhe', 'UserController@viewAllMsg')->name('viewallmsg');
        Route::post('/dashboard/mesazhe/fshi', 'UserController@fshiMsg')->name('fshiMsg');

        Route::get('/dashboard/raporte', 'InventarController@raporte')->name('listRaporte');

    });
        Route::get('/logout', 'UserController@logout')->name('logout');

});
Route::get('/pass', 'UserController@pass')->name('password');
//

<?php

use Illuminate\Support\Facades\Route;

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

Route::any('/', 'ProductController@index')->name('products.index');
Route::group(['middleware' => 'auth'],function(){
    Route::any('/list', 'ProductController@productList')->name('products.list');

    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::post('/products/create', 'ProductController@store')->name('products.store');

    Route::get('/products/{id}/edit', 'ProductController@edit')->name('products.edit');
    Route::patch('/products/{id}/edit', 'ProductController@update')->name('products.update');

    Route::delete('/products/{id}', 'ProductController@destroy')->name('products.destroy');
});
//Route::get('/reset', 'ProductController@reset')->name('reset');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

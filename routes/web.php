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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/createTable', 'TablesController@createTable');
Route::get('/getTables', 'TablesController@getTables');
Route::put('/updateTable/{id}', 'TablesController@updateTable');
Route::post('/deleteTable/{id}', 'TablesController@deleteTable');
Route::post('/createCategory', 'CategoriesController@createCategory');
Route::get('/getCategories', 'CategoriesController@getCategories');
Route::put('/updateCategory/{id}', 'CategoriesController@updateCategory');
Route::post('/deleteCategory/{id}', 'CategoriesController@deleteCategory');
Route::post('/createProduct', 'ProductsController@createProduct');
Route::get('/getProducts', 'ProductsController@getProducts');
Route::put('/updateProduct/{id}', 'ProductsController@updateProduct');
Route::post('/deleteProduct/{id}', 'ProductsController@deleteProduct');
Route::options('/{path}', function(){
    return '';
})->where('path', '.*');



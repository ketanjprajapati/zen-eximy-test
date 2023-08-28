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
    return view('home');
});
Route::get('/add-customer','CustomerController@add')->name('add');
Route::get('/list-customers','CustomerController@list')->name('list');
Route::post('save','CustomerController@saveRecord');
Route::get('/view-orders', 'CustomerController@viewOrders');
Route::view('list-customers','listCustomer');

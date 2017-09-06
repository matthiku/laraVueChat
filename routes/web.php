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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

// provide authorization routes
Auth::routes();

// provide the current user object to the frontend
Route::get('/user', function () {
    return Auth::user();
})->middleware('auth')->name('user');

// chatroom 
Route::get('/chat', function () {
    return view('chat.chat');
})->middleware('auth')->name('chat');

// Messages CRUD methods
Route::resource('messages', 'MessageController')->middleware('auth');

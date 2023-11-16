<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('admin.pages.dashboard.index');
});


Route::get('/user', function () {
    return view('admin.pages.user.index');
});


Route::get('/user/create', function () {
    return view('admin.pages.user.create');
});


Route::get('/empty', function () {
    return view('admin.pages.empty');
});

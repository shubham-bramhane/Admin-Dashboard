<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;

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



// user resource

Route::resource('dashboard', DashboardController::class);

Route::resource('users', UserController::class);

Route::resource('customers', CustomerController::class);
Route::get('customers/status/{id}', [CustomerController::class, 'status'])->name('customers.status');


Route::get('/empty', function () {
    return view('admin.pages.empty');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\RoleController;

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
    // return view('welcome');
    return redirect()->route('admin.login');
});


Route::get('/empty', function () {
    return view('admin.pages.empty');
});

Auth::routes();
Route::get('admin/login', function () {
    return view('admin.pages.auth.login');
})->name('admin.login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth','checkLogin'])->prefix('admin')->name('admin.')
->group(function () {

    Route::resource('dashboard', DashboardController::class);

    Route::resource('users', UserController::class);
    Route::get('users/status/{id}', [UserController::class, 'status'])->name('users.status');

    Route::resource('customers', CustomerController::class);
    Route::get('customers/status/{id}', [CustomerController::class, 'status'])->name('customers.status');

    Route::resource('roles', RoleController::class);
    Route::get('roles/status/{id}', [RoleController::class, 'status'])->name('roles.status');
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('user/logout', [App\Http\Controllers\Auth\LoginController::class, 'logoutUser'])->name('user.logout');

Route::group(['prefix' => 'admin'], function(){
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/login', [App\Http\Controllers\AuthAdmin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\AuthAdmin\LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [App\Http\Controllers\AuthAdmin\LoginController::class, 'logoutAdmin'])->name('admin.logout');
    Route::post('/password/email', [App\Http\Controllers\AuthAdmin\ForgotPasswordController::class, 'sendResetLinkAccount'])->name('admin.password.email');
    Route::get('/password/reset', [App\Http\Controllers\AuthAdmin\ForgotPasswordController::class, 'showPasswordResetForm'])->name('admin.password.request');
    Route::get('/password/reset/{token}', [App\Http\Controllers\AuthAdmin\ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('/password/reset', [App\Http\Controllers\AuthAdmin\ResetPasswordController::class, 'reset'])->name('admin.password.update');
});



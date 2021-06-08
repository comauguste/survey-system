<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
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
    return view('index');
})->middleware('auth')->name('index');

Route::get('admin/logout', [Controller::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('admin/user', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('users.delete');
});

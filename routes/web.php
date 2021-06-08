<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PublicSurveyController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
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


Route::group(['prefix' => 'survey'], function () {
    Route::get('/{uuid}', [PublicSurveyController::class, 'show'])->name('public_survey.show');
    Route::get('/s/{s_link}', [PublicSurveyController::class, 'shareableLink'])->name('public_survey.shareable_link');
});

Route::group(['prefix' => 'surveys'], function () {
    Route::get('/', [SurveyController::class, 'index'])->name('surveys');

    Route::get('/{uuid}/run', [SurveyController::class, 'run'])->name('surveys.run');
    Route::get('/{uuid}/pause', [SurveyController::class, 'pause'])->name('surveys.pause');

    Route::get('/{survey}', [SurveyController::class, 'show'])->name('surveys.show');
    Route::get('/survey', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/store', [SurveyController::class, 'store'])->name('surveys.store');
    Route::post('/update/{survey}', [SurveyController::class, 'update'])->name('surveys.update');
    Route::get('/delete/{survey}', [SurveyController::class, 'destroy'])->name('surveys.delete');
});

Route::group(['prefix' => 'questions'], function () {
    Route::get('/{survey}/{q_uuid}', [QuestionController::class, 'show'])->name('questions.show');
    Route::get('/{uuid}', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/store/{survey}', [QuestionController::class, 'store'])->name('questions.store');
    Route::post('/update/{survey}/{question}', [QuestionController::class, 'update'])->name('questions.update');
    Route::get('/delete/{survey}/{q_uuid}', [QuestionController::class, 'delete'])->name('questions.delete');
});

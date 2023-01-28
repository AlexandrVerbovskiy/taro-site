<?php

use App\Http\Controllers\AreasActivityController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PasswordController;

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

Route::post('/file-save', [MediaController::class, 'save']);

Route::get('/registration', [RegistrationController::class, 'create']);
Route::post('/registration', [RegistrationController::class, 'store']);
Route::get('/edit-profile', [UserController::class, 'editProfile']);
Route::post('/edit-profile', [UserController::class, 'saveProfile']);

Route::get('/login', [SessionsController::class, 'create']);
Route::post('/login', [SessionsController::class, 'store']);
Route::get('/logout', [SessionsController::class, 'destroy']);

Route::get('/forget-password', [PasswordController::class, 'showForgetPasswordForm']);
Route::post('/forget-password', [PasswordController::class, 'submitForgetPasswordForm']);
Route::get('/reset-password/{token}', [PasswordController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [PasswordController::class, 'submitResetPasswordForm']);

Route::get("/create-activity", [AreasActivityController::class, 'create']);
Route::get("/edit-activity/{id}", [AreasActivityController::class, 'edit']);
Route::post("/save-activity", [AreasActivityController::class, 'save']);

Route::get("/titles", [AreasActivityController::class, 'titles']);
Route::get("/topic/{id}", [AreasActivityController::class, 'topic']);

Route::get("/create-master", [MastersController::class, 'create']);
Route::get("/edit-master/{id}", [MastersController::class, 'edit']);
Route::post("/save-master", [MastersController::class, 'save']);
Route::get("/masters", [MastersController::class, 'masters']);
Route::get("/master/{id}", [MastersController::class, 'master']);

Route::get("/create-study-topic", [StudiesController::class, 'createTopic']);
Route::get("/edit-study-topic/{id}", [StudiesController::class, 'editTopic']);
Route::post("/save-study-topic", [StudiesController::class, 'saveTopic']);

Route::get("/create-study", [StudiesController::class, 'createStudy']);
Route::get("/edit-study/{id}", [StudiesController::class, 'editStudy']);
Route::post("/create-study", [StudiesController::class, 'saveStudy']);
Route::get("/studies/{id}", [StudiesController::class, 'studies']);
Route::get("/study/{id}", [StudiesController::class, 'study']);

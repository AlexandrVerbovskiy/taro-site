<?php

use App\Http\Controllers\AreasActivityController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InfosController;
use App\Http\Controllers\MastersController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MastersCommentsController;
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

Route::get('/', [MainController::class, 'home']);
Route::get('/admin', [MainController::class, 'admin']);
Route::get('/admin/masters', [MainController::class, 'masters']);
Route::get("/admin/activities", [MainController::class, 'activities']);
Route::get("/admin/infos", [MainController::class, 'infos']);
Route::get("/admin/studies-topics", [MainController::class, 'studiesTopics']);
Route::get("/admin/events-topics", [MainController::class, 'eventsTopics']);
Route::get("/admin/users", [MainController::class, 'users']);
Route::get("/admin/events", [MainController::class, 'events']);
Route::get("/admin/infos-posts", [MainController::class, 'infosPosts']);
Route::get("/admin/studies", [MainController::class, 'studies']);
Route::get("/admin/main-settings", [MainController::class, 'mainPageSettings']);
Route::get("/admin/comments", [MainController::class, 'comments']);

Route::post("/admin/save-main", [MainController::class, 'saveMain']);
Route::get("/admin/comments", [MainController::class, 'comments']);
Route::get("/admin/get-comments", [MainController::class, 'getComments']);
Route::post("/admin/master-comment-delete", [MastersCommentsController::class, 'delete']);

Route::get("/admin/calendar", [MainController::class, 'calendar']);

Route::get('/admin/get-infos-posts', [MainController::class, 'getInfosPosts']);
Route::get('/admin/get-events', [MainController::class, 'getEvents']);
Route::get('/admin/get-studies', [MainController::class, 'getStudies']);

Route::get("/admin/get-users", [UserController::class, 'asyncUsers']);
Route::get("/admin/change-admin-users", [UserController::class, 'changeUsers']);

Route::post('/file-save', [MediaController::class, 'save']);

Route::get('/registration', [RegistrationController::class, 'create']);
Route::post('/registration', [RegistrationController::class, 'store']);
Route::get('/edit-profile', [UserController::class, 'editProfile']);
Route::post('/edit-profile', [UserController::class, 'saveProfile']);
Route::get('/users-admins', [UserController::class, 'usersForAdmin']);

Route::get('/login', [SessionsController::class, 'create']);
Route::post('/login', [SessionsController::class, 'store']);
Route::get('/logout', [SessionsController::class, 'destroy']);

Route::get('/forget-password', [PasswordController::class, 'showForgetPasswordForm']);
Route::post('/forget-password', [PasswordController::class, 'submitForgetPasswordForm']);
Route::get('/reset-password/{token}', [PasswordController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [PasswordController::class, 'submitResetPasswordForm']);

Route::get("/admin/create-activity", [AreasActivityController::class, 'create']);
Route::get("/admin/edit-activity/{id}", [AreasActivityController::class, 'edit']);
Route::post("/admin/save-activity", [AreasActivityController::class, 'save']);
Route::post("/admin/activity-change-visible", [AreasActivityController::class, 'changeVisible']);
Route::post("/admin/activity-delete", [AreasActivityController::class, 'delete']);
Route::get("/area-activity/{id}", [AreasActivityController::class, 'topic']);

Route::get("/masters", [MastersController::class, 'masters']);
Route::get("/master/{id}", [MastersController::class, 'master']);
Route::post("/get-master-comments", [MastersCommentsController::class, 'getForMaster']);
Route::post("/create-master-comments", [MastersCommentsController::class, 'create']);
Route::get("/admin/create-master", [MastersController::class, 'create']);
Route::get("/admin/edit-master/{id}", [MastersController::class, 'edit']);
Route::post("/admin/save-master", [MastersController::class, 'save']);
Route::post("/admin/master-change-visible", [MastersController::class, 'changeVisible']);
Route::post("/admin/master-delete", [MastersController::class, 'delete']);

Route::get("/admin/create-study-topic", [StudiesController::class, 'createTopic']);
Route::get("/admin/edit-study-topic/{id}", [StudiesController::class, 'editTopic']);
Route::post("/admin/save-study-topic", [StudiesController::class, 'saveTopic']);
Route::post("/admin/study-topic-change-visible", [StudiesController::class, 'changeVisibleTopic']);
Route::post("/admin/study-topic-delete", [StudiesController::class, 'deleteTopic']);

Route::get("/admin/create-study", [StudiesController::class, 'createStudy']);
Route::get("/admin/edit-study/{id}", [StudiesController::class, 'editStudy']);
Route::post("/admin/edit-study", [StudiesController::class, 'saveStudy']);
Route::post('/admin/study-change-visible', [StudiesController::class, 'changeVisibleStudy']);
Route::post('/admin/study-delete', [StudiesController::class, 'deleteStudy']);

Route::get('/get-studies', [StudiesController::class, 'getStudies']);
Route::get("/studies/{id}", [StudiesController::class, 'studies']);

Route::get("/calendar-times/{date}", [CalendarController::class, 'getTimes']);
Route::post("/calendar-time-edit", [CalendarController::class, 'saveTimeCalendar']);

Route::get("/admin/create-info", [InfosController::class, 'createInfo']);
Route::get("/admin/edit-info/{id}", [InfosController::class, 'editInfo']);
Route::post("/admin/save-info", [InfosController::class, 'saveInfo']);
Route::post("/admin/info-change-visible", [InfosController::class, 'changeVisible']);
Route::post("/admin/info-delete", [InfosController::class, 'delete']);

Route::get("/admin/create-info-post", [InfosController::class, 'createPost']);
Route::get("/admin/edit-info-post/{id}", [InfosController::class, 'editPost']);
Route::post("/admin/save-info-post", [InfosController::class, 'savePost']);
Route::post("/admin/info-post-change-visible", [InfosController::class, 'changeVisiblePost']);
Route::post("/admin/info-post-delete", [InfosController::class, 'deletePost']);
Route::get('/get-infos-posts', [InfosController::class, 'getPosts']);
Route::get('/infos-posts/{id}', [InfosController::class, 'infosPosts']);

Route::get('/admin/create-topic-event', [EventsController::class, 'createTopic']);
Route::get('/admin/edit-topic-event/{id}', [EventsController::class, 'editTopic']);
Route::post('/admin/save-topic-event', [EventsController::class, 'saveTopic']);
Route::post("/admin/topic-event-change-visible", [EventsController::class, 'changeVisibleTopic']);
Route::post("/admin/topic-event-delete", [EventsController::class, 'deleteTopic']);

Route::get('/admin/create-event', [EventsController::class, 'createPost']);
Route::get('/admin/edit-event/{id}', [EventsController::class, 'editPost']);
Route::post('/admin/save-event', [EventsController::class, 'savePost']);
Route::post('/admin/event-post-delete', [EventsController::class, 'deletePost']);
Route::post('/admin/event-post-change-visible', [EventsController::class, 'changeVisiblePost']);
Route::get('/event-posts/{id}', [EventsController::class, 'events']);
Route::get('/get-events', [EventsController::class, 'getPosts']);


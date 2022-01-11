<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\EventTemplateController;
use App\Http\Controllers\EventController;

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

// Route::middleware('auth:sanctum')->group(function(){ 
//     Route::get('/index', function () {
//         return view('index', ['title' => 'カレンダー']);
//     });
// });

Route::get('/', function () {
    return view('index', ['title' => 'カレンダー']);
})->name('index');

Route::get('/login', [LoginLogoutController::class, 'login']);
Route::get('/logout', [LoginLogoutController::class, 'logout']);
Route::post('/loginCheck', [LoginLogoutController::class, 'loginCheck']);
Route::get('/newAccount', [UserController::class, 'newAccount']);
Route::get('/privacyPolicy', function() {
    return view('privacyPolicy', ['title' => 'プライバシーポリシー']);
});
Route::get('/config/{id}', [ConfigController::class, 'show']);
Route::patch('/config/{id}/update', [ConfigController::class, 'update'])
    ->name('config.update');
Route::get('/eventTemplate', [EventTemplateController::class, 'index'])
    ->name('eventTemplate');
Route::post('/eventTemplate/create', [EventTemplateController::class, 'create'])
    ->name('eventTemplate.create');
Route::get('/userList', [UserController::class, 'list']);
Route::get('/userDetail/{id}', [UserController::class, 'show']);
Route::get('/userRegist', [UserController::class, 'regist']);
Route::post('/user/create', [UserController::class, 'create'])
    ->name('user.create');
Route::get('/eventList', [EventController::class, 'list']);
Route::get('/eventRegist', [EventController::class, 'regist']);
Route::get('/eventDetail/{id}', [EventController::class, 'show']);
Route::post('/event/create', [EventController::class, 'create'])
    ->name('event.create');
Route::post('/event/{id}/update', [EventController::class, 'update'])
    ->name('event.update');
Route::post('/event/{id}/delte', [EventController::class, 'delete'])
    ->name('event.delete');
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\EventTemplateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginLogoutController::class, 'login']);
// Route::post('login', [LoginLogoutController::class, 'loginCheck']);
// Route::get('eventTemplate/getList', [EventTemplateController::class, 'getList']);
// Route::get('eventTemplate/get/{id}', [EventTemplateController::class, 'get']);
// Route::post('eventTemplate/delete/{id}', [EventTemplateController::class, 'delete']);
// Route::post('user/getList', [UserController::class, 'getUserList']);
// Route::get('userDetail/{id}', [UserController::class, 'get']);
// Route::post('userDetail/{id}/blacklist', [UserController::class, 'updateBlacklist']);
// Route::post('userDetail/{id}/authority', [UserController::class, 'updateAuthority']);
// Route::get('user/categories',[UserController::class, 'fetchUserCategories']);
// Route::post('event/getList', [EventController::class, 'getEventList']);
// Route::get('eventDetail/{id}', [EventController::class, 'get']);

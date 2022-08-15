<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\EventTemplateController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventUserController;

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
Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::post('/logout', [LoginLogoutController::class, 'logout']);

  // イベントテンプレート
  Route::post('/eventTemplate', [EventTemplateController::class, 'create']);
  Route::put('/eventTemplate', [EventTemplateController::class, 'create']);
  Route::get('/getTemplateList', [EventTemplateController::class, 'getList']);
  Route::get('/getTemplate/{id}', [EventTemplateController::class, 'get']);
  Route::delete('/eventTemplate/{id}', [EventTemplateController::class, 'delete']);

  // プライバシーポリシー
  Route::get('/privacyPolicy', [PrivacyPolicyController::class, 'get']);
  Route::post('/privacyPolicy', [PrivacyPolicyController::class, 'update']);
  Route::put('/privacyPolicy', [PrivacyPolicyController::class, 'update']);
  
  // ユーザーカテゴリ
  Route::get('/userCategory', [UserCategoryController::class, 'all']);
  Route::post('/userCategory', [UserCategoryController::class, 'updateAll']);

  // ユーザー
  Route::get('/getUserList', [UserController::class, 'getUserList']);
  Route::get('/user/{id}', [UserController::class, 'get']);

  // イベント
  Route::get('/event/{id}', [EventController::class, 'get']);
  Route::post('/event', [EventController::class, 'create']);
  Route::put('/event', [EventController::class, 'update']);
  Route::delete('/event/{id}', [EventController::class, 'delete']);
  Route::get('/getEventByMonth/{year}/{month}', [EventController::class, 'getEventByMonth']);
  Route::get('searchEvent', [EventController::class, 'search']);

  // イベント参加者
  Route::get('/getEventUser/{id}', [EventUserController::class, 'getEventUser']);
  Route::post('/eventUser', [EventUserController::class, 'create']);
  Route::delete('/eventUser/{eventId}', [EventUserController::class, 'delete']);
  Route::get('getEventListByUser/{userId}', [EventUserController::class, 'getEventListByUser']);
});

Route::post('login', [LoginLogoutController::class, 'login']);
// Route::post('login', [LoginLogoutController::class, 'loginCheck']);
// Route::post('eventTemplate/delete/{id}', [EventTemplateController::class, 'delete']);
// Route::post('user/getList', [UserController::class, 'getUserList']);
// Route::get('userDetail/{id}', [UserController::class, 'get']);
// Route::post('userDetail/{id}/blacklist', [UserController::class, 'updateBlacklist']);
// Route::post('userDetail/{id}/authority', [UserController::class, 'updateAuthority']);
// Route::get('user/categories',[UserController::class, 'fetchUserCategories']);
// Route::post('event/getList', [EventController::class, 'getEventList']);
// Route::get('eventDetail/{id}', [EventController::class, 'get']);

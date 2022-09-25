<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\EventTemplateController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InquiryController;

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
  // ログアウト
  Route::post('/logout', [LoginLogoutController::class, 'logout']);

  // パスワード変更
  Route::post('/changePassword', [LoginLogoutController::class, 'changePassword']);

  // コンフィグ
  Route::get('config', [ConfigController::class, 'get']);
  Route::post('config', [ConfigController::class, 'update']);

  // イベントテンプレート
  Route::get('/getAlleventTemplate', [EventTemplateController::class, 'all']);
  Route::post('/eventTemplate', [EventTemplateController::class, 'create']);
  Route::put('/eventTemplate', [EventTemplateController::class, 'update']);
  Route::get('/getTemplateList', [EventTemplateController::class, 'getList']);
  Route::get('/getTemplate/{id}', [EventTemplateController::class, 'get']);
  Route::delete('/eventTemplate/{id}', [EventTemplateController::class, 'delete']);

  // プライバシーポリシー
  Route::get('/policy/{type}', [PolicyController::class, 'get']);
  Route::post('/policy', [PolicyController::class, 'update']);
  Route::put('/policy', [PolicyController::class, 'update']);
  
  // ユーザーカテゴリ
  Route::post('/userCategory', [UserCategoryController::class, 'updateAll']);

  // ユーザー
  Route::get('/getUserList', [UserController::class, 'getUserList']);
  Route::get('/user/{id}', [UserController::class, 'get']);
  Route::delete('/user/{id}', [UserController::class, 'delete']);
  Route::put('/role', [UserController::class, 'updateRole']);
  Route::put('/status', [UserController::class, 'updateStatus']);
  Route::put('/user', [UserController::class, 'update']);
  
  // イベント
  Route::get('/event/{id}', [EventController::class, 'get']);
  Route::post('/event', [EventController::class, 'create']);
  Route::put('/event', [EventController::class, 'update']);
  Route::delete('/event/{id}', [EventController::class, 'delete']);
  Route::get('searchEvent', [EventController::class, 'search']);
  
  // イベント参加者
  Route::get('/getEventUser/{id}', [EventUserController::class, 'getEventUser']);
  Route::post('/eventUser', [EventUserController::class, 'create']);
  Route::delete('/eventUser/{id}', [EventUserController::class, 'delete']);
  Route::get('/getEventListByUser/{userId}', [EventUserController::class, 'getEventListByUser']);
  Route::post('/bulkResevation', [EventUserController::class, 'bulkResevation']);
  Route::put('/changeEventUserStatus', [EventUserController::class, 'changeStatus']);
  Route::get('/getLinePushTargetUserCount/{eventId}', [EventUserController::class, 'getLinePushTargetUserCount']);
  
  // 売上
  Route::put('/eventUserSales', [SalesController::class, 'inputEventUserSales']);
  Route::put('/reflectEventDetail/{eventId}', [SalesController::class, 'reflectEventDetail']);
  Route::put('/monthlySales', [SalesController::class, 'inputMonthlySales']);
  Route::get('/getMonthlySales/{year}', [SalesController::class, 'getMonthlySales']);
  Route::get('/getAllSales', [SalesController::class, 'getAllSales']);

  // ニュース
  Route::post('/news', [NewsController::class, 'create']);
  Route::get('/getAllNews', [NewsController::class, 'getAllNews']);
  Route::get('/getNewNews', [NewsController::class, 'getNewNews']);

  // 問い合わせ
  Route::post('/inquiry', [InquiryController::class, 'create']);
  Route::get('/getInquiries', [InquiryController::class, 'all']);
  Route::get('inquiry/{id}', [InquiryController::class, 'get']);
  Route::put('updateInquiryStatus', [InquiryController::class, 'updateStatus']);
  Route::delete('inquiry/{id}', [InquiryController::class, 'delete']);
});

Route::post('login', [LoginLogoutController::class, 'login']);
Route::post('lineLogin/{code}', [LoginLogoutController::class, 'lineLogin']);
Route::post('webhook', [LineController::class, 'webhook']);
Route::get('/getEventByMonth/{year}/{month}', [EventController::class, 'getEventByMonth']);
Route::post('/user', [UserController::class, 'create']);
Route::get('/userCategory', [UserCategoryController::class, 'all']);
Route::post('/forgot-password', [LoginLogoutController::class, 'forgotPassword']);

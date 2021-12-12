<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\EventTemplateController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Models\Member;

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

Route::post('login', [LoginLogoutController::class, 'loginCheck']);
Route::get('eventTemplate/getList', [EventTemplateController::class, 'getList']);
Route::get('eventTemplate/get/{id}', [EventTemplateController::class, 'get']);
Route::post('eventTemplate/delete/{id}', [EventTemplateController::class, 'delete']);
Route::post('member/getList', [MemberController::class, 'getMemberList']);
Route::get('memberDetail/{id}', [MemberController::class, 'get']);
Route::post('memberDetail/{id}/blacklist', [MemberController::class, 'updateBlacklist']);
Route::post('memberDetail/{id}/authority', [MemberController::class, 'updateAuthority']);
Route::post('event/getList', [EventController::class, 'getEventList']);

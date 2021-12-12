<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\MemberController;
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
Route::get('/newAccount', [MemberController::class, 'newAccount']);
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
Route::get('/memberManagement', [MemberController::class, 'management']);
Route::get('/memberDetail/{id}', [MemberController::class, 'show']);
Route::get('/memberRegist', [MemberController::class, 'regist']);
Route::post('/member/create', [MemberController::class, 'create'])
    ->name('member.create');
Route::get('/eventList', [EventController::class, 'list']);
Route::get('/eventDetail/{id}', [EventController::class, 'show']);


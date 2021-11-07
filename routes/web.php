<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginLogoutController;
use App\Http\Controllers\MemberController;

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

Route::middleware('auth:sanctum')->group(function(){ 
    Route::get('/index', function () {
        return view('index', ['title' => 'カレンダー']);
    });
});

Route::get('/', function () {
    return view('index', ['title' => 'カレンダー']);
});

Route::get('/login', [LoginLogoutController::class, 'login']);
Route::post('/loginCheck', [LoginLogoutController::class, 'loginCheck']);
Route::get('/newAccount', [MemberController::class, 'newAccount']);


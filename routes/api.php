<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//autenticación
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('jwt.verify')->group(function () {
    
    //cierre de sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    //user
    Route::get('/user', [AuthController::class, 'getInfoUser'])->name('getInfoUser');
});

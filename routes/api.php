<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PetController;
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

    //rutas para administración de personas
    Route::controller(PeopleController::class)
        ->prefix('people')->group(function () {
            Route::get('/all', 'getPeople')->name('people.getPeople');
            Route::post('/', 'store')->name('people.store');
            Route::get('/{id}', 'show')->name('people.show');
            Route::put('/{id}', 'update')->name('people.update');
            Route::delete('/{id}', 'destroy')->name('people.destroy');
        });

    //rutas para administración de mascotas
    Route::controller(PetController::class)
        ->prefix('pets')->group(function () {
            Route::get('/', 'getPets')->name('pets.getPets');
            Route::post('/', 'store')->name('pets.store');
            Route::get('/{id}', 'show')->name('pets.show');
            Route::put('/{id}', 'update')->name('pets.update');
            Route::delete('/{id}', 'destroy')->name('pets.destroy');
        });
});

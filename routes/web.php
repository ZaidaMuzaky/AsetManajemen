<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\logincontroller;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [logincontroller::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [logincontroller::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

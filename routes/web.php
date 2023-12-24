<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ApiController::class,'index'])->name('index');
Route::get('/{sehirAdi}-hava-durumu', [ApiController::class,'showWeather'])->name('showWeather');
Route::get('/search', [ApiController::class, 'search'])->name('search');




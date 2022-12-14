<?php

use App\Http\Controllers\backend\TextController;
use Illuminate\Support\Facades\Route;

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


#_-------------------------------------
Route::post('/texts', [TextController::class,'index'])
    ->name('get.texts');
Route::put('/texts/edit', [TextController::class,'editText'])
    ->name('edit.texts');
Route::post('/texts/delete', [TextController::class,'deleteText'])
    ->name('delete.texts');

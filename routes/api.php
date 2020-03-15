<?php

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

Route::get('test', 'Auth\AuthController@test')->name('test');
Route::post('login', 'Auth\AuthController@login')->name('login');
Route::post('signup', 'Auth\AuthController@signup')->name('login');

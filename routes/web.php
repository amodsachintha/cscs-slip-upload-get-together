<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/45427346a3dea51c7a10fe6e3584f267','HomeController@handleYourDetailsSave')->name('handleYourDetailsSave');
Route::post('/d8c046f6559df69ff6c7638136d1ab11','HomeController@handlePlusOneSave')->name('handlePlusOneSave');
Route::post('/88e7d1fe65ee9adfc371111db727802c','HomeController@handleSlipUpload')->name('handleSlipUpload');



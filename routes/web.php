<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieDataController;
use App\Models\movieData;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieDataController as mdc;
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

// Avoid inline functions and prefer controllers — limits caching/performance


Route::get('/', function () {
  $obj = new MovieDataController();
  $obj->initDataWorks();
  //$obj->getMovieByName('game of thrones');
  return view('index');
});

Route::get('/find', function(){

  return view('findDevice');
});


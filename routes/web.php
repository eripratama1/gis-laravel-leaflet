<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CentrePointController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\SpaceController;
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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/map',[App\Http\Controllers\MapController::class,'index'])->name('map.index');
Route::get('/map/{slug}',[App\Http\Controllers\MapController::class,'show'])->name('map.show');

Route::resource('centre-point',(CentrePointController::class));
Route::resource('category',(CategoryController::class));
Route::resource('space',(SpaceController::class));

Route::get('/centrepoint/data',[DataController::class,'centrepoint'])->name('centre-point.data');
Route::get('/categories/data',[DataController::class,'categories'])->name('data-category');
Route::get('/spaces/data',[DataController::class,'spaces'])->name('data-space');

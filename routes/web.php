<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\PageController;
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

/*Auth::routes();*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('pages', PageController::class)->only(["index", "store"]);
Route::any('pages/data', [ PageController::class, 'anyData']);

Route::resource('applications', ApplicationController::class)->only(["index", "store"]);
Route::any('applications/data', [ ApplicationController::class, 'anyData']);

Route::any('collections/data', [ CollectionController::class, 'anyData']);
Route::resource('collections', CollectionController::class)->except(["create", "destroy"]);

Route::get('/{hash}', [App\Http\Controllers\PageController::class, 'show'])->where('hash', '.+');

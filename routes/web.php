<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitController;
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
//Route::get('/', [HomeController::class, 'index'])->name('visits.index');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [VisitController::class, 'index'])->name('visits.index');
    Route::get('/create', [VisitController::class, 'create'])->name('visits.create');
    Route::post('/store', [VisitController::class, 'store'])->name('visits.store');
    Route::get('/stats', [VisitController::class, 'showStats'])->name('visits.stats');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


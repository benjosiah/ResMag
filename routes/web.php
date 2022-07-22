<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PagesController;
use Inertia\Inertia;
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

Route::get('/',[PagesController::class, 'index']);

Route::get('/admin', [PagesController::class, 'admin'])->name('admin');

Route::prefix('resources')->group(function (){
    Route::post('/', [ResourceController::class, 'store'])->name('resources.store');
    Route::post('/{resource}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');
});


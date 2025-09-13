<?php

use App\Http\Controllers\LoveController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LoveController::class, 'index']);

Route::get('/loves', [
    LoveController::class, 'index'
])->name('loves.index');

Route::post('/loves/calculate', [
    LoveController::class, 'calculate'
])->name('loves.calculate');

Route::get('/loves/calculate', [
    LoveController::class, 'calculate'
]);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;


// Главная
Route::get('/', [EmailController::class, 'index'])->name('home');

// Создать почту → сразу в инбокс
Route::get('/email/create', [EmailController::class, 'create'])->name('email.create');

// Найти почту → в ее инбокс
Route::post('/email/find', [EmailController::class, 'find'])->name('email.find');

// Страница инбокса (главная рабочая)
Route::get('/email/{email}', [EmailController::class, 'show'])->name('email.show');

// Удалить почту
Route::delete('/email/{email}', [EmailController::class, 'destroy'])->name('email.destroy');
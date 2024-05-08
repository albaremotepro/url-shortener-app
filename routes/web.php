<?php

use App\Http\Controllers\UrlController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [UrlController::class, 'index']);
Route::post('/urls', [UrlController::class, 'store']);
Route::get('/default/{hash}', [UrlController::class, 'redirect']);

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookImportController;

Route::apiResource('books', BookController::class);

Route::post(
    '/books/import',
    [BookImportController::class, 'import']
);

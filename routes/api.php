<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PublishersController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('authors', AuthorsController::class);
Route::post('/author/{author}/add-publisher/{publisher}', [AuthorsController::class, 'addPublisher']);
Route::get('/authors-publishers/{author}', [AuthorsController::class, 'returnPublisher']);

Route::apiResource('books', BooksController::class);
Route::apiResource('publishers', PublishersController::class);

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/current-user', [UserController::class, 'show']);
});

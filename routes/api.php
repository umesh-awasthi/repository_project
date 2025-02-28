<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController\TodoController;

// API Routes
Route::get('/todos', [TodoController::class, 'apiIndex'])->name('api.todos.index');
Route::get('/todos/{id}', [TodoController::class, 'apiShow'])->name('api.todos.show');
Route::post('/todos', [TodoController::class, 'apiStore'])->name('api.todos.store');
Route::put('/todos/{id}', [TodoController::class, 'apiUpdate'])->name('api.todos.update');
Route::delete('/todos/{id}', [TodoController::class, 'apiDestroy'])->name('api.todos.destroy');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController\TodoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;

// Web Routes
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');

// Admin Routes
Route::get('/admin/role', [AdminController::class, 'show'])->name('roles');
Route::get('/admin/role/{id}', [AdminController::class, 'edit'])->name('role.edit');
Route::put('/admin/role/{id}', [AdminController::class, 'update'])->name('role.update');
Route::delete('/admin/role/{id}', [AdminController::class, 'delete'])->name('roles.delete');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/roles', [AdminController::class, 'createRole'])->name('admin.createRole');
Route::post('/admin/roles', [AdminController::class, 'storeRole']);
Route::get('/admin/permissions', [AdminController::class, 'createPermission'])->name('admin.createPermission');
Route::post('/admin/permissions', [AdminController::class, 'storePermission']);
Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
Route::post('/admin/assign-permission', [AdminController::class, 'assignPermission']);
Route::get('/todos/{id}/edit', [TodoController::class, 'edit'])->name('todos.edit');
Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');

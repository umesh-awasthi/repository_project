<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController\TodoController;
use App\Http\Controllers\AdminController;

// Web Routes
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');

// Admin Routes
Route::get('/admin/role', [AdminController::class, 'show'])->name('roles');
Route::get('/admin/viewpermissions', [AdminController::class, 'viewPermissions'])->name('viewPermissions');

Route::post('/admin/assign-permission', [AdminController::class, 'assignPermission'])->name('admin.assignPermission');
Route::get('/admin/setting', [AdminController::class, 'setting'])->name('admin.setting');
Route::get('/admin/role/{id}', [AdminController::class, 'edit'])->name('role.edit');
Route::put('/admin/role/{id}', [AdminController::class, 'update'])->name('role.update');
Route::delete('/admin/role/{id}', [AdminController::class, 'deleteRole'])->name('roles.delete');
Route::get('/register', [AdminController::class, 'createuser'])->name('register');
Route::post('/register', [AdminController::class, 'storeuser']);

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/roles', [AdminController::class, 'createRole'])->name('admin.createRole');
Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('admin.users');
Route::get('/admin/users/{id}', [AdminController::class, 'edituser'])->name('admin.user.edit');
Route::put('/admin/users/{id}', [AdminController::class, 'updateuser'])->name('admin.user.update');
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteuser'])->name('admin.user.delete');
Route::post('/admin/roles', [AdminController::class, 'storeRole']);
Route::get('/admin/permissions', [AdminController::class, 'createPermission'])->name('admin.createPermission');
Route::post('/admin/permissions', [AdminController::class, 'storePermission']);
Route::delete('/admin/permissions/{id}', [AdminController::class, 'deletePermission'])->name('deletePermission');
Route::post('/admin/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');

Route::get('/todos/{id}/edit', [TodoController::class, 'edit'])->name('todos.edit');
Route::put('/todos/{id}', [TodoController::class, 'update'])->name('todos.update');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');

// New Dashboard Route
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

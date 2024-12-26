<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('tasks.dashboard');
});

// Group routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard route for tasks
    Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('tasks.dashboard');

    // Specific route for calendar (place this BEFORE the resource routes)
    Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');

    // Resource routes for tasks (excluding the show method to avoid conflict with calendar)
    Route::resource('tasks', TaskController::class)->except(['show']);

    // Route for showing a specific task (add constraints for numeric IDs)
    Route::get('/tasks/{task}', [TaskController::class, 'show'])
        ->where('task', '[0-9]+') // Restrict to numeric IDs only
        ->name('tasks.show');

    // Toggle task status
    Route::patch('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');

    // Resource routes for categories (only create, store, and index)
    Route::resource('categories', CategoryController::class)->only(['create', 'store', 'index']);

    // Route for deleting a category
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Include authentication routes (login, register, etc.)
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/dashboard/products', \App\Http\Controllers\ProductController::class);
    Route::resource('/dashboard/categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('/dashboard/keywords', \App\Http\Controllers\KeywordController::class);
    Route::resource('/dashboard/answers', \App\Http\Controllers\AnswerController::class);
    Route::resource('/dashboard/users', \App\Http\Controllers\UserController::class);
    Route::resource('/dashboard/orders', \App\Http\Controllers\OrderController::class);
});

require __DIR__.'/auth.php';

// ANCIEN ROOT

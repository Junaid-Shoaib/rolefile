<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\First;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('first',First::class)->name('first')->middleware('auth');

// Users

Route::get('users', [UserController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('users/create', [UserController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::get('users/{user}', [UserController::class, 'show'])
    ->name('users.show')
    ->middleware('auth');

Route::post('users', [UserController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UserController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

// Documents

Route::get('documents', [DocumentController::class, 'index'])
    ->name('documents')
    ->middleware('auth');

Route::get('documents/create', [DocumentController::class, 'create'])
    ->name('documents.create')
    ->middleware('auth');

Route::get('documents/{document}', [DocumentController::class, 'show'])
    ->name('documents.show')
    ->middleware('auth');

Route::post('documents', [DocumentController::class, 'store'])
    ->name('documents.store')
    ->middleware('auth');

Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])
    ->name('documents.edit')
    ->middleware('auth');

Route::put('documents/{document}', [DocumentController::class, 'update'])
    ->name('documents.update')
    ->middleware('auth');

Route::delete('documents/{document}', [DocumentController::class, 'destroy'])
    ->name('documents.destroy')
    ->middleware('auth');

// Details

Route::get('details', [DetailController::class, 'index'])
    ->name('details')
    ->middleware('auth');

Route::get('details/create', [DetailController::class, 'create'])
    ->name('details.create')
    ->middleware('auth');

Route::get('details/{detail}', [DetailController::class, 'show'])
    ->name('details.show')
    ->middleware('auth');

Route::post('details', [DetailController::class, 'store'])
    ->name('details.store')
    ->middleware('auth');

Route::get('details/{detail}/edit', [DetailController::class, 'edit'])
    ->name('details.edit')
    ->middleware('auth');

Route::put('details/{detail}', [DetailController::class, 'update'])
    ->name('details.update')
    ->middleware('auth');

Route::delete('details/{detail}', [DetailController::class, 'destroy'])
    ->name('details.destroy')
    ->middleware('auth');

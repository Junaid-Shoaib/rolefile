<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\First;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\Excel;
use App\Http\Controllers\Gen;
// use Illuminate\Support\Facades\Storage;

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

// Companies

Route::get('companies', [CompanyController::class, 'index'])
    ->name('companies')
    ->middleware('auth');

Route::get('companies/create', [CompanyController::class, 'create'])
    ->name('companies.create')
    ->middleware('auth');

Route::get('companies/{company}', [CompanyController::class, 'show'])
    ->name('companies.show')
    ->middleware('auth');

Route::post('companies', [CompanyController::class, 'store'])
    ->name('companies.store')
    ->middleware('auth');

Route::get('companies/{company}/edit', [CompanyController::class, 'edit'])
    ->name('companies.edit')
    ->middleware('auth');

Route::put('companies/{company}', [CompanyController::class, 'update'])
    ->name('companies.update')
    ->middleware('auth');

Route::delete('companies/{company}', [CompanyController::class, 'destroy'])
    ->name('companies.destroy')
    ->middleware('auth');

Route::get('companies/{company}', [CompanyController::class, 'coch'])
    ->name('companies.coch')
    ->middleware('auth');

// Years

Route::get('years', [YearController::class, 'index'])
    ->name('years')
    ->middleware('auth');

Route::get('years/create', [YearController::class, 'create'])
    ->name('years.create')
    ->middleware('auth');

Route::get('years/{year}', [YearController::class, 'show'])
    ->name('years.show')
    ->middleware('auth');

Route::post('years', [YearController::class, 'store'])
    ->name('years.store')
    ->middleware('auth');

Route::get('years/{year}/edit', [YearController::class, 'edit'])
    ->name('years.edit')
    ->middleware('auth');

Route::put('years/{year}', [YearController::class, 'update'])
    ->name('years.update')
    ->middleware('auth');

Route::delete('years/{year}', [YearController::class, 'destroy'])
    ->name('years.destroy')
    ->middleware('auth');

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

Route::post('folder', [DocumentController::class, 'folder'])
    ->name('folder')
    ->middleware('auth');

// Route::get('/clone', [DocumentController::class, 'clone'])
//     ->name('clone')
//     ->middleware('auth');

// Route::get('/indexx', [DocumentController::class, 'indexx'])
//     ->name('indexx')
//     ->middleware('auth');

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

// Excel

Route::get('/excel', Excel::class)->name('excel')->middleware('auth');
Route::get('/gen', Gen::class)->name('gen')->middleware('auth');


// Google drive

// Route::get('test', function() {
//     Storage::disk('google')->put('test2.txt', 'Hello World2');
// });

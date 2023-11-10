<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;
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
    return view('AdminPanel');
});

Route::get('/dashboard', function () {
    return view('AdminPanel');
});

Route::get('/Blogs', function () {
    return view('AdminPages.Blogs');
});
Route::get('/Users', function () {
    return view('AdminPages.users');
});
Route::get('/AdminProfile', function () {
    return view('AdminPages.profile');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/GetUsers', [AdminController::class, 'getUsers']);

require __DIR__ . '/auth.php';

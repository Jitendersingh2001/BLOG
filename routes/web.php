<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
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
    return view('Home');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return view('AdminPanel');
    })->name('admin.dashboard');

    Route::get('/Blogs', function () {
        return view('Adminpages.blogs');
    })->name('admin.blogs');

    Route::get('/Users', function () {
        return view('Adminpages.users');
    })->name('admin.users');

    Route::get('/AdminProfile', function () {
        return view('Adminpages.profile');
    })->name('admin.profile');
});








Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/GetUsers', [AdminController::class, 'getUsers']);
Route::get('/getCategories', [BlogController::class, 'GetCategory']);
Route::get('/GetBlogs', [BlogController::class, 'GetBlogs']);
Route::post('/CreateBlog', [BlogController::class, 'CreateBlog']);
Route::get('/editBlog/{id}', [BlogController::class, 'GetBlog']);
Route::delete('/blog/{id}', [BlogController::class, 'DeleteBlog']);
Route::post('/updateBlog', [BlogController::class, 'UpdateBlog']);
Route::get('/GetSarchedBlogs/{keyword}', [BlogController::class, 'GetSearchedBlogs']);
require __DIR__ . '/auth.php';

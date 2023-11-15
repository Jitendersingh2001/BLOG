<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
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
    if (Auth::check()) {
        $user = Auth::user();
        $userRole = $user->roles->role;
        if ($userRole && $userRole == ROLE::ADMIN) {
            return redirect()->route('admin.dashboard');
        }
    }
    return view('Home');
});

// ADMIN ROUTES
Route::group(['middleware' => ['auth', 'isAdmin']], function () {
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



Route::get('/Access', function () {
    return view('AccessDenied');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// User Routes
Route::get('/GetUsers', [AdminController::class, 'getUsers']);
Route::get('/GetUser/{id}', [AdminController::class, 'GetUser']);
Route::get('/GetSearchedUsers/{id}', [AdminController::class, 'GetSearchedUser']);
Route::post('/updateUser/{id}', [AdminController::class, 'UpdateUser']);
Route::delete('/deleteUser/{id}', [AdminController::class, 'DeleteUser']);
// Blog Routes
Route::get('/getCategories', [BlogController::class, 'GetCategory']);
Route::get('/GetBlogs', [BlogController::class, 'GetBlogs']);
Route::get('/GetCategoryBlogs/{keyword}', [BlogController::class, 'GetCategoryBlogs']);
Route::post('/CreateBlog', [BlogController::class, 'CreateBlog']);
Route::get('/editBlog/{id}', [BlogController::class, 'GetBlog']);

Route::delete('/blog/{id}', [BlogController::class, 'DeleteBlog']);
Route::post('/updateBlog', [BlogController::class, 'UpdateBlog']);
Route::get('/GetSarchedBlogs/{keyword}', [BlogController::class, 'GetSearchedBlogs']);
Route::get('/GetSpecificBlog/{id}', [BlogController::class, 'GetSpecificBlog']);
// Comments Route
Route::post('/CommentOnBlog', [CommentController::class, 'AddComment']);
Route::get('/ShowComments/{id}', [CommentController::class, 'GetComment']);
require __DIR__ . '/auth.php';

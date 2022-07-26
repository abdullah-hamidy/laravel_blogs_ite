<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\TagController;
use App\Http\Controllers\admin\CategoryController;

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
Route::group(['prefix' => 'admin', 'middleware'=>'auth'], function(){
// Route::group(['prefix' => 'admin'], function(){

    Route::resource('profile', ProfileController::class);
    Route::resource('post', PostController::class);
    Route::resource('tag', TagController::class);
    Route::resource('category', CategoryController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin');
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::put('/register/{user}/password', [RegisterController::class, 'UpdatePassword'])->name('register.password');
    Route::put('/register/{user}/update', [RegisterController::class, 'UpdateUser'])->name('register.update');
});


// Guest Related Routes
Route::middleware(['guest'])->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});


//LANDING PAGE ROUTES

Route::get('/', function () {
    return view('landing.index');
})->name('index');

Route::get('/about', function(){
    return view('landing.about');
})->name('about');

Route::get('/contact', function(){
    return view('landing.contact');
})->name('contact');

Route::get('/category', function(){
    return view('landing.category');
})->name('category');

Route::get('/post', function(){
    return view('landing.post');
})->name('post');
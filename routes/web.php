<?php

use Illuminate\Support\Facades\Route;

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
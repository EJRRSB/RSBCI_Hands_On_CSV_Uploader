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
// WELCOME
Route::get('/', function () {
    return view('welcome');
});
 
//AUTH
Auth::routes();
 
//PROFILE
Route::get('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile.index');
Route::get('/profile/{user}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');

//POST
Route::get('/post/create', [App\Http\Controllers\PostsController::class,'create']);
Route::post('/post', [App\Http\Controllers\PostsController::class,'store']);
Route::get('/post/{post}', [App\Http\Controllers\PostsController::class,'show']);
Auth::routes();

// NAV
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\Dashboard::class, 'index'])->name('dashboard');


//DATA TABLE 
Route::get('/forbes/getForbesData', [App\Http\Controllers\ForbesController::class, 'getForbesData'])->name('getForbesData');

// AJAX UPLOAD CSV
Route::post('/forbes', [App\Http\Controllers\ForbesController::class,'store']);

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
 

// NAV
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\Dashboard::class, 'index'])->name('dashboard');
//DATA CHARTS
Route::get('/dashboard/getCountsData', [App\Http\Controllers\Dashboard::class, 'getCountsData'])->name('getCountsData');
Route::get('/dashboard/getChartData', [App\Http\Controllers\Dashboard::class, 'getChartData'])->name('getChartData');




//DATA TABLE 
Route::get('/forbes/getForbesData', [App\Http\Controllers\ForbesController::class, 'getForbesData'])->name('getForbesData');


// AJAX UPLOAD/IMPORT CSV
Route::post('/forbes', [App\Http\Controllers\ForbesController::class,'store']);


// EXPORT CSV 
Route::post('/getAvailableDates', [App\Http\Controllers\ForbesController::class,'getAvailableDates']);
Route::post('/csv_report', [App\Http\Controllers\ForbesController::class,'getDownloadReports']);

// GENERATE CSV
Route::get('/getMaxData', [App\Http\Controllers\ForbesController::class,'getMaxData']);
Route::post('/generateCsvLimit', [App\Http\Controllers\ForbesController::class,'generateCsvLimit']);


// CREATE CSV DATA SAMPLE
Route::get('/create_csv', [App\Http\Controllers\CsvController::class,'create_csv']);

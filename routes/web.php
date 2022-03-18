<?php

use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['web', 'auth', 'roles']], function () {
    Route::group(['roles' => 'admin'], function () {
        // Route::post('question_upload', 'ExcelController@question');
        Route::resource('semester', '\App\Http\Controllers\Admin\SemesterController');
        Route::resource('kurikulum', '\App\Http\Controllers\Admin\KurikulumController');
    });
    Route::group(['roles' => 'dosen'], function () {
        
    });
    Route::group(['roles' => 'operator'], function () {
    });
    Route::group(['roles' => 'mahasiswa'], function () {
    });
    Route::group(['roles' => ['admin', 'dosen','kajur','prodi']], function () {
        Route::resource('matakuliah', MataKuliahDosenController::class);
    });
    Route::group(['roles' => ['admin','kajur','prodi']], function () {
        Route::resource('validasi-mata-kuliah', ValidasiMataKuliahController::class);
    });
    
});
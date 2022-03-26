<?php

use App\Http\Controllers\Admin\ApiSiaConnectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Dosen\MataKuliahController;
use App\Models\Config;
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
        Route::post('/semester-aktif', [SemesterController::class, 'SemesterAktif']);
        Route::resource('config', '\App\Http\Controllers\Admin\ConfigController');
        Route::post('/config-aktif', [ConfigController::class, 'ConfigAktif']);
        Route::resource('category', '\App\Http\Controllers\Admin\CategoryController');
        Route::post('/sync-category-fakultas', [CategoryController::class, 'SyncCategoryFakultas']);
        Route::post('/sync-category-prodi', [CategoryController::class, 'SyncCategoryProdi']);
        Route::resource('user', UserController::class);
        // Route::post('/sync-mahasiswa', [UserController::class, 'SyncMahasiswa']);
        Route::post('/sync-dosen', [UserController::class, 'SyncDosen']);
        
        Route::get('/api-test', [ApiSiaConnectionController::class, 'index']);
        Route::post('/api-conn', [ApiSiaConnectionController::class, 'ApiConnection']);
    });
    Route::group(['roles' => 'dosen'], function () {
        
    });
    Route::group(['roles' => 'operator'], function () {
    });
    Route::group(['roles' => 'mahasiswa'], function () {
    });
    Route::group(['roles' => ['admin', 'dosen']], function () {
        Route::resource('mata-kuliah', MataKuliahController::class);
        Route::post('/buat-mata-kuliah', [MataKuliahController::class, 'MakeMKLMS']);
        Route::post('/enrol-dosen-mata-kuliah', [MataKuliahController::class, 'EnrolDosen']);
    });
    Route::group(['roles' => ['admin','kajur','prodi']], function () {
        // Route::resource('validasi-mata-kuliah', ValidasiMataKuliahController::class);
    });
    
});
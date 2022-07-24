<?php

use App\Http\Controllers\Admin\ApiSiaConnectionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Dosen\EnrolController;
use App\Http\Controllers\Dosen\GroupingMahasiswaController;
use App\Http\Controllers\Dosen\MataKuliahController;
use App\Http\Controllers\Mahasiswa\MataKuliahMahasiswaController;
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
        Route::resource('/sync-mahasiswa', MahasiswaController::class);
        Route::post('/sync-dosen', [UserController::class, 'SyncDosen']);
        Route::post('/get-dosen-1', [UserController::class, 'GetDosen1']);
        Route::post('/get-mahasiswa-1', [MahasiswaController::class, 'GetMahasiswa1']);
        Route::post('/create-user-lms', [UserController::class, 'CreateUserLms']);
        Route::post('/create-mahasiswa-lms', [MahasiswaController::class, 'CreateUserLms']);
        Route::post('/sync-mahasiswa-lms', [MahasiswaController::class, 'SyncMahasiswa']);
        
        Route::get('/api-test', [ApiSiaConnectionController::class, 'index']);
        Route::post('/api-conn', [ApiSiaConnectionController::class, 'ApiConnection']);
    });
    Route::group(['roles' => 'dosen'], function () {
        
    });
    Route::group(['roles' => 'operator'], function () {
    });
    Route::group(['roles' => 'mahasiswa'], function () {
        Route::resource('mata-kuliah-mahasiswa', MataKuliahMahasiswaController::class);
        Route::post('/get-mk-mahasiswa', [MataKuliahMahasiswaController::class, 'getMkMahasiswa']);
        
    });
    Route::group(['roles' => ['admin', 'dosen']], function () {
        Route::resource('mata-kuliah', MataKuliahController::class);
        Route::post('/buat-mata-kuliah', [MataKuliahController::class, 'MakeMKLMS']);
        Route::post('/enrol-dosen-mata-kuliah', [EnrolController::class, 'EnrolDosen']);
        Route::post('/enrol-mahasiswa-mata-kuliah', [EnrolController::class, 'EnrolMahasiswa']);
        Route::post('/get-mk-dosen', [MataKuliahController::class, 'getMkDosen']);
        

        Route::post('/buat-grup-mata-kuliah', [GroupingMahasiswaController::class, 'AddGroupMk']);
        Route::post('/add-mhs-grup-mata-kuliah', [GroupingMahasiswaController::class, 'AddMhsGroupMk']);
    });
    Route::group(['roles' => ['admin', 'dosen','mahasiswa']], function () {
        Route::get('/sso-lms', [MataKuliahController::class, 'ActionMoodle']);            
        Route::get('/login-lms', [MataKuliahController::class, 'LoginLMS']);
        Route::post('/get-detail-mk', [MataKuliahController::class, 'getDetailMK']);
        Route::get('/my-profile', [UserController::class, 'MyProfile']);
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        
    });
    
});
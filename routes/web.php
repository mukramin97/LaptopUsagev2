<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/loginProcess', [LoginController::class, 'loginProcess'])->name('loginProcess');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::middleware('auth')->resource('kelas', KelasController::class);
Route::get('kelasExport', [KelasController::class, 'kelasExport'])->name('kelasExport')->middleware('auth');
Route::post('kelasImport', [KelasController::class, 'kelasImport'])->name('kelasImport')->middleware('auth');

Route::middleware('auth')->resource('siswa', SiswaController::class);
Route::get('siswaExport', [SiswaController::class, 'siswaExport'])->name('siswaExport')->middleware('auth');
Route::post('siswaImport', [SiswaController::class, 'siswaImport'])->name('siswaImport')->middleware('auth');

Route::middleware('auth')->resource('penggunaan', PenggunaanController::class);
Route::post('storeByNISN', [PenggunaanController::class, 'storeByNISN'])->name('storeByNISN')->middleware('auth');
Route::post('updateByNISN', [PenggunaanController::class, 'updateByNISN'])->name('updateByNISN')->middleware('auth');
Route::get('penggunaanExport', [PenggunaanController::class, 'penggunaanExport'])->name('penggunaanExport')->middleware('auth');

Route::middleware('auth')->resource('dashboard', DashboardController::class);

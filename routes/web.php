<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerpustakaanController;

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

Route::middleware('superadmin')->resource('kelas', KelasController::class);
Route::get('kelasExport', [KelasController::class, 'kelasExport'])->name('kelasExport')->middleware('auth');
Route::post('kelasImport', [KelasController::class, 'kelasImport'])->name('kelasImport')->middleware('superadmin');

Route::middleware('superadmin')->resource('siswa', SiswaController::class);
Route::get('siswaExport', [SiswaController::class, 'siswaExport'])->name('siswaExport')->middleware('auth');
Route::post('siswaImport', [SiswaController::class, 'siswaImport'])->name('siswaImport')->middleware('superadmin');

Route::middleware('adminloker')->resource('penggunaan', PenggunaanController::class)->except(['destroy']);
Route::middleware('superadmin')->resource('penggunaan', PenggunaanController::class)->only(['destroy']);
Route::post('storeByNISN', [PenggunaanController::class, 'storeByNISN'])->name('storeByNISN')->middleware('adminloker');
Route::post('updateByNISN', [PenggunaanController::class, 'updateByNISN'])->name('updateByNISN')->middleware('adminloker');
Route::get('penggunaanExport', [PenggunaanController::class, 'penggunaanExport'])->name('penggunaanExport')->middleware('adminloker');

Route::middleware('auth')->resource('dashboard', DashboardController::class)->only(['index']);

Route::middleware('adminperpus')->resource('perpustakaan', PerpustakaanController::class)->except(['destroy']);
Route::middleware('superadmin')->resource('perpustakaan', PerpustakaanController::class)->only(['destroy']);
Route::post('storePerpusByNISN', [PerpustakaanController::class, 'storePerpusByNISN'])->name('storePerpusByNISN')->middleware('adminperpus');
Route::post('updatePerpusByNISN', [PerpustakaanController::class, 'updatePerpusByNISN'])->name('updatePerpusByNISN')->middleware('adminperpus');
Route::get('perpustakaanData', [PerpustakaanController::class, 'indexData'])->name('perpustakaanData')->middleware('adminperpus');
Route::get('perpustakaanExport', [PerpustakaanController::class, 'perpustakaanExport'])->name('perpustakaanExport')->middleware('adminperpus');

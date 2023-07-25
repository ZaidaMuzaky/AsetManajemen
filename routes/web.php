<?php

use App\Http\Controllers\DataAnakController;
use App\Http\Controllers\DataKeluargaController;
use App\Http\Controllers\DataOrganisasiController;
use App\Http\Controllers\DataPasanganController;
use App\Http\Controllers\DataTrainingController;
use App\Http\Controllers\DataSertifikasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\NIPController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TipePegawaiController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\CetakLabelController;
use App\Http\Controllers\DaftarPenggunaController;
use App\Http\Controllers\DataAsetController;
use App\Http\Controllers\DataMutasiController;
use App\Http\Controllers\DetailDataAset;
use App\Http\Controllers\DetailDataAsetController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\MonitoringController;
use App\Models\DaftarPengguna;
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

Auth::routes();
Route::get('/register', function () {
    return redirect('/login');
});

Route::post('/register', function () {
    return redirect('/login');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profil', [ProfileController::class, 'view',])->name('User.viewprofil');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('User.editprofil');
    Route::put('/profil/update/{id}', [ProfileController::class, 'update'])->name('User.updateprofil');
});

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::resource('DaftarPengguna', DaftarPenggunaController::class);

Route::resource('divisi', DivisiController::class);

Route::resource('memo', MemoController::class);

Route::resource('JenisBarang', JenisBarangController::class);

Route::resource('admin', UsersController::class)->middleware(['auth', 'role:superadmin']);;

Route::resource('detail-aset', DetailDataAsetController::class);
Route::get('detail-aset/history/{id}', [DetailDataAsetController::class, 'history'])->name('detail-aset.history');

// Monitoring
Route::get('monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');
Route::get('monitoring/detail/{id}', [MonitoringController::class, 'show'])->name('monitoring.show');
Route::get('monitoring/create/{id}', [MonitoringController::class, 'create'])->name('monitoring.create');
Route::post('monitoring/store/{id}', [MonitoringController::class, 'store'])->name('monitoring.store');
Route::get('monitoring/edit/{id}', [MonitoringController::class, 'edit'])->name('monitoring.edit');
Route::put('monitoring/update/{id}', [MonitoringController::class, 'update'])->name('monitoring.update');
Route::delete('monitoring/{id}', [MonitoringController::class, 'destroy'])->name('monitoring.destroy');
Route::delete('monitoring/all/{id}', [MonitoringController::class, 'destroyAll'])->name('monitoring.destroy-all');

// Cetak Label
Route::resource('cetak-label', CetakLabelController::class);
// Data Mutasi
Route::resource('data-mutasi', DataMutasiController::class);
Route::resource('memo', MemoController::class);
Route::resource('berita-acara', BeritaAcaraController::class);

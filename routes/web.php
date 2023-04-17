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
use App\Http\Controllers\DataAsetController;
use App\Http\Controllers\DivisiController;
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

Route::resource('Karyawan', PegawaiController::class);
Route::group(
    [
        'prefix' => '/karyawan',
        'middleware' => 'auth'
    ],
    function () {
        Route::post('/export', [PegawaiController::class, 'export'])->name('Karyawan.export');
        Route::post('/import', [PegawaiController::class, 'import'])->name('Karyawan.import');
    }
);

Route::get('getDataKaryawan', [PegawaiController::class, 'getDataKaryawan']);

Route::resource('NIP', NIPController::class);
Route::group(
    [
        'prefix' => '/nip',
        'middleware' => 'auth'
    ],
    function () {
        Route::post('/export', [NIPController::class, 'export'])->name('NIP.export');
    }
);

Route::group(
    [
        'prefix' => '/get',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/getSK', [NIPController::class, 'getSK']);
        Route::get('/getNO/{id}/{sk}', [NIPController::class, 'getNoUrut']);
        Route::get('/getNoUrut/{id}/{sk}', [NIPController::class, 'getNoUrutBaru']);
        Route::get('/getDataNip/{id_peg}/{no_sk}/{no_urut}', [NIPController::class, 'getDataNip']);
        Route::get('/ceknip/{id_peg}/{no_sk}/{no_urut}/{nama_lengkap}', [NIPController::class, 'cekNIP']);
        Route::get('/getUnitKerja/{nama}', [PegawaiController::class, 'getUnitKerja']);
    }
);

Route::resource('Keluarga', DataKeluargaController::class);
Route::group(
    [
        'prefix' => '/keluarga',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/export', [DataKeluargaController::class, 'export'])->name('Keluarga.export');
        Route::get('/save', [DataAnakController::class, 'saveDataKeluarga'])->name('Keluarga.save');
        Route::post('/import', [DataKeluargaController::class, 'import'])->name('Keluarga.import');
    }
);

Route::resource('Pasangan', DataPasanganController::class);
Route::group(
    [
        'prefix' => '/Pasangan',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/{Pasangan}/create', [DataPasanganController::class, 'buat'])->name('Pasangan.buat');
    }
);
Route::resource('Anak', DataAnakController::class);

Route::group(
    [
        'prefix' => '/Anak',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/{id}/create', [DataAnakController::class, 'buat'])->name('Anak.buat');
        Route::get('/list/{idkeluarga}', [DataAnakController::class, 'list'])->name('Anak.list');
    }
);

Route::resource('divisi', DivisiController::class);
Route::resource('Training', DataTrainingController::class);
Route::group(
    [
        'prefix' => '/training',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/{idpegawai}/list', [DataTrainingController::class, 'listtraining'])->name('Training.list');
        Route::DELETE('/{idpegawai}/deleteall', [DataTrainingController::class, 'destroyall'])->name('Training.deleteall');
        Route::get('/export', [DataTrainingController::class, 'export'])->name('Training.export');
        Route::post('/import', [DataTrainingController::class, 'import'])->name('Training.import');
    }
);

Route::resource('Sertifikasi', DataSertifikasiController::class);
Route::group(
    [
        'prefix' => '/sertifikasi',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/{idpegawai}/list', [DataSertifikasiController::class, 'listsertifikasi'])->name('Sertifikasi.list');
        Route::DELETE('/{idpegawai}/deleteall', [DataSertifikasiController::class, 'destroyall'])->name('Sertifikasi.deleteall');
        Route::get('/export', [DataSertifikasiController::class, 'export'])->name('Sertifikasi.export');
        Route::post('/import', [DataSertifikasiController::class, 'import'])->name('Sertifikasi.import');
    }
);

Route::resource('Jabatan', JabatanController::class);

Route::resource('Organisasi', DataOrganisasiController::class);
Route::group(
    [
        'prefix' => '/organisasi',
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/export', [DataOrganisasiController::class, 'export'])->name('Organisasi.export');
        Route::post('/import', [DataOrganisasiController::class, 'import'])->name('Organisasi.import');
    }
);
Route::resource('admin', UsersController::class)->middleware(['auth', 'role:superadmin']);;

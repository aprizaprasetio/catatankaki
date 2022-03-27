<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\catatanController;

/*
|--------------------------------------------------------------------------
|
| Aplikasi Peduli Diri
| Disusun oleh Apriza Prasetio
|
|--------------------------------------------------------------------------
|
| Instagram : @aprizaprasetio
| Youtube : Apriza Prasetio
|
|--------------------------------------------------------------------------
*/

// *Autentikasi akun grup route 
Route::group(['middleware'=>'akun'], function() {// <-Route group di middleware yang sama/akun
    Route::match(['get', 'post'], '/masuk', [catatanController::class, 'masukClass']);// <-Route masuk/login untuk ke url/get dan untuk proses/post
    Route::match(['get', 'post'], '/daftar', [catatanController::class, 'daftarClass']);// <-Route daftar/register untuk ke url/get dan untuk proses/post
});
Route::post('/keluar', [catatanController::class, 'keluarClass']);// <-Route fungsi keluar/logout

// *Aplikasi
Route::get('/', [catatanController::class, 'berandaClass'])->middleware('autentikasi');// <-Route halaman beranda/home
Route::group(['middleware'=>'autentikasi'], function() {// <-Route group di middleware yang sama/akun
    Route::match(['get', 'post'], '/catatan-perjalanan', [catatanController::class, 'catatan_perjalananClass']);// <-Route masuk/login untuk ke url/get dan untuk proses/post
    Route::match(['get', 'post'], '/isi-data', [catatanController::class, 'isi_dataClass']);// <-Route daftar/register untuk ke url/get dan untuk proses/post
});
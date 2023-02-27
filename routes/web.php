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


Auth::routes([
    'register' => false,
    'reset' => false, 
]);

/* Route::get('/home', 'HomeController@index')->name('home'); */

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/pegawai', 'PegawaiController@index')->name('pegawai')/* ->middleware('checkrole') */;
Route::get('/pegawai/view/{id}', 'PegawaiController@view')->name('pegawai.view');
Route::get('/pegawai/search', 'PegawaiController@search')->name('pegawai.search');
Route::get('/pegawai/editjabatan', 'PegawaiController@edit')->name('pegawai.editjabatan');

Route::get('/ujian', 'UjianController@index')->name('ujian');
Route::get('/ujian/search', 'UjianController@search')->name('ujian.search');
Route::get('/ujian/create', 'UjianController@create')->name('ujian.create');
Route::post('/ujian/store', 'UjianController@store')->name('ujian.store');
Route::get('/ujian/edit/{id}', 'UjianController@edit')->name('ujian.edit');
Route::post('/ujian/update/{id}', 'UjianController@update')->name('ujian.update');
Route::post('/ujian/destroy/{id}', 'UjianController@destroy')->name('ujian.destroy');

Route::get('/sub-ujian', 'SubUjianController@index')->name('sub_ujian');
Route::get('/sub-ujian/search', 'SubUjianController@search')->name('sub_ujian.search');
Route::get('/sub-ujian/create', 'SubUjianController@create')->name('sub_ujian.create');
Route::post('/sub-ujian/store', 'SubUjianController@store')->name('sub_ujian.store');
Route::get('/sub-ujian/edit/{id}', 'SubUjianController@edit')->name('sub_ujian.edit');
Route::post('/sub-ujian/update/{id}', 'SubUjianController@update')->name('sub_ujian.update');
Route::post('/sub-ujian/destroy/{id}', 'SubUjianController@destroy')->name('sub_ujian.destroy');

Route::get('/dokumen', 'DokumenController@index')->name('dokumen');
Route::get('/dokumen/search', 'DokumenController@search')->name('dokumen.search');
Route::get('/dokumen/create', 'DokumenController@create')->name('dokumen.create');
Route::post('/dokumen/store', 'DokumenController@store')->name('dokumen.store');
Route::get('/dokumen/edit/{id}', 'DokumenController@edit')->name('dokumen.edit');
Route::post('/dokumen/update/{id}', 'DokumenController@update')->name('dokumen.update');
Route::post('/dokumen/destroy/{id}', 'DokumenController@destroy')->name('dokumen.destroy');

Route::get('/user', 'UserController@index')->name('user');
Route::get('/user/create', 'UserController@create')->name('user.create');
Route::post('/user/store', 'UserController@store')->name('user.store');
Route::get('/user/edit/{id}', 'UserController@edit')->name('user.edit');
Route::post('/user/update/{id}', 'UserController@update')->name('user.update');
Route::post('/user/destroy/{id}', 'UserController@destroy')->name('user.destroy');

Route::get('/pendaftaran', 'PendaftaranController@index')->name('pendaftaran');
Route::get('/pendaftaran/create', 'PendaftaranController@create')->name('pendaftaran.create');
Route::get('/pendaftaran/search', 'PendaftaranController@search')->name('pendaftaran.search');
Route::post('/pendaftaran/store', 'PendaftaranController@store')->name('pendaftaran.store');
Route::post('/pendaftaran/destroy/{id}', 'PendaftaranController@destroy')->name('pendaftaran.destroy');
Route::get('/pendaftaran/view/{id}', 'PendaftaranController@view')->name('pendaftaran.view');
Route::post('/pendaftaran/upload', 'PendaftaranController@upload')->name('pendaftaran.upload');
Route::post('/pendaftaran/kirim', 'PendaftaranController@kirim')->name('pendaftaran.kirim');

Route::get('/pengantar', 'PengantarController@index')->name('pengantar');
Route::get('/pengantar/create', 'PengantarController@create')->name('pengantar.create');
Route::get('/pengantar/search', 'PengantarController@search')->name('pengantar.search');
Route::post('/pengantar/store', 'PengantarController@store')->name('pengantar.store');
Route::post('/pengantar/destroy/{id}', 'PengantarController@destroy')->name('pengantar.destroy');
Route::get('/pengantar/view/{id}', 'PengantarController@view')->name('pengantar.view');
Route::get('/pengantar/edit/{id}', 'PengantarController@edit')->name('pengantar.edit');
Route::post('/pengantar/update', 'PengantarController@update')->name('pengantar.update');
Route::post('/pengantar/upload', 'PengantarController@upload')->name('pengantar.upload');
Route::post('/pengantar/kirim', 'PengantarController@kirim')->name('pengantar.kirim');

Route::get('/verifikasi', 'VervalController@index')->name('verifikasi');
Route::get('/verifikasi/getPendaftaran', 'VervalController@getPendaftaran')->name('verifikasi.getPendaftaran');
Route::get('/verifikasi/data', 'VervalController@data')->name('verifikasi.data');
Route::get('/verifikasi/view/{id}', 'VervalController@view')->name('verifikasi.view');
Route::get('changeStatus', 'VervalController@changeStatus');
Route::post('/verifikasi/proses', 'VervalController@proses')->name('verifikasi.proses');
Route::post('/verifikasi/kirim', 'VervalController@kirim')->name('verifikasi.kirim');
Route::post('/verifikasi/batal', 'VervalController@batal')->name('verifikasi.batal');
Route::post('/verifikasi/kembalikan', 'VervalController@kembalikan')->name('verifikasi.kembalikan');
Route::post('/verifikasi/tolak', 'VervalController@tolak')->name('verifikasi.tolak');
Route::post('/verifikasi/destroy/{id}', 'VervalController@destroy')->name('verifikasi.destroy');

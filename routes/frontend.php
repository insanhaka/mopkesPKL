<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/qrcode/{id}', 'ReportController@preview');
Route::get('/laporan/{id}', 'ReportController@laporanform');
Route::post('/kirim', 'ReportController@kirimlaporan');

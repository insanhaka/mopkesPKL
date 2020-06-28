<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/qrcode/{nik}', 'ReportController@preview');
Route::get('/laporan/{id}', 'ReportController@laporanform');

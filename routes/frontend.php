<?php
use Illuminate\Support\Facades\Route;

Route::get('/sqrcode/{nik}', 'QrcodeController@sqrcode');
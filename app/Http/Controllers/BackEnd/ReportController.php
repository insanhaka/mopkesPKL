<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Seller;

class ReportController extends Controller
{
    // public function preview($nik)
    // {
    //     $data = App\Seller::where('nik', $nik)->all();

    //     return view('preview', ['seller' => $data]);
    // }

    public function preview()
    {
        return view('preview');
    }
}
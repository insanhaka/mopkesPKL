<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agreement;
use App\Kelompok;
use DB;

class ApiControl extends Controller
{
    public function apiAgreement()
    {
        $data = DB::table('agreements')
                    ->select('name','nik')
                    ->get();

        return response()->json([
            'value' => $data
        ]);
    }
}

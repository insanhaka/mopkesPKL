<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
// use App\Kelompok;
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

    public function activation(Request $request)
    {
        $active = $request->is_active;
        $id = $request->id;

         DB::table('business')
            ->where('id', $id)
            ->update(['is_active' => $active]);
    }

    public function getbusiness()
    {
        $data = DB::table('business')
                    ->get();

        return response()->json([
            'business' => $data
        ]);
    }

    public function getreport()
    {
        $data = DB::table('reports')
                    ->get();

        return response()->json([
            'report' => $data
        ]);
    }

    public function getreportMount()
    {
        $data = Report::orderBy('count', 'desc')->select(DB::raw('nik_id,count(*) as count'))->groupBy('nik_id')->get();
    }

    public function getalamat()
    {
        $prov = DB::table('provinces')
                    ->select('id','name')
                    ->get();
        $kab = DB::table('regencies')
                    ->select('id', 'province_id', 'name')
                    ->get();
        $kec = DB::table('districts')
                    ->select('id', 'regency_id', 'name')
                    ->get();
        $des = DB::table('villages')
                    ->select('id', 'district_id', 'name')
                    ->get();

        return response()->json([
            'prov' => $prov,
            'kab' => $kab,
            'kec' => $kec,
            'des' => $des
        ]);
    }

}

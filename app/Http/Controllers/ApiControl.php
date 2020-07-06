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

    public function getbusiness(Request $request)
    {
        $data = DB::table('business')
                    ->get();

        return response()->json([
            'business' => $data
        ]);
    }

    public function getreport(Request $request)
    {
        $data = DB::table('reports')
                    ->get();

        return response()->json([
            'report' => $data
        ]);
    }

    public function getreportMount(Request $request)
    {
        $data = Report::orderBy('count', 'desc')->select(DB::raw('nik_id,count(*) as count'))->groupBy('nik_id')->get();
    }

}

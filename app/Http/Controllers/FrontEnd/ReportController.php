<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Business;
use DB;

class ReportController extends Controller
{
    public function preview($id)
    {
        $data = DB::table('business')
                ->where('id', $id)->get();

        return view('frontend.preview', ['business' => $data]);
    }

    public function laporanform($id)
    {
        $data = DB::table('business')
    			->where('id', $id)
                ->get();

        // dd($data);

    	return view('frontend.form', ['laporan' => $data]);
    }

    public function kirimlaporan(Request $request)
    {
        $reports = new Report;
        $reports->about = $request->about;
        $reports->description = $request->description;
        $reports->nik_id = $request->id;

        $reports->save();

        return view('frontend.thanks');
    }

}

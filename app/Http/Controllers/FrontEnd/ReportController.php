<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Business;
use DB;

class ReportController extends Controller
{
    public function preview($nik)
    {
        $data = DB::table('business')
        		->join('sectors', 'business.sector_id', '=', 'sectors.id')
                ->where('nik_id', $nik)->get();

        return view('frontend.preview', ['business' => $data]);
    }

    public function laporanform($nik_id)
    {
    	$data = DB::table('business')
    			->where('nik_id', $nik_id)
    			->get();

    	return view('frontend.form', ['laporan' => $data]);
    }

    public function kirimlaporan(Request $request)
    {
        $nik = $request->nik_id;

        $databusiness = Business::where('nik_id', $nik)->first();

        $reports = new Report;
        $reports->about = $request->about;
        $reports->description = $request->description;
        $reports->nik_id = $databusiness->id;

        $reports->save();

        return view('frontend.thanks');
    }

}

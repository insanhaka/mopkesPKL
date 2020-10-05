<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Business;
use Carbon\Carbon;
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
        $datalaporan = DB::table('reports')
                    ->select('reporter', DB::raw('DATE(`created_at`) as date'), 'nik_id')
                    ->whereIn('id', function($query){
                        $query->selectRaw('max(id) from `reports`')->groupBy('reporter');
                    })
                    ->orderBy('reporter')
                    ->get();

        $date = Carbon::now()->toDateString();

        foreach ($datalaporan as $laporan) {
            if($request->ip == $laporan->reporter && $date == $laporan->date && $request->id == $laporan->nik_id){
                return view('frontend.sorry');
            }
        }

        $reports = new Report;
        $reports->rating = $request->rating;
        $reports->about = $request->about;
        $reports->description = $request->description;
        $reports->nik_id = $request->id;
        $reports->reporter = $request->ip;

        $reports->save();

        return view('frontend.thanks');
    }

}

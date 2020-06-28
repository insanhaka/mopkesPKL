<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Seller;
use DB;

class ReportController extends Controller
{
    public function preview($nik)
    {
        $data = DB::table('sellers')
        		->join('products', 'sellers.product_id', '=', 'products.id')
        		->where('nik', $nik)->get();

        return view('frontend.preview', ['seller' => $data]);
    }

    public function laporanform($id)
    {
    	$data = DB::table('sellers')
    			->where('id', $id)
    			->get();

    	return view('frontend.form', ['laporan' => $data]);
    }

    public function kirimlaporan(Request $request)
    {
        // dd($request->all());

        $reports = new Report;
        $reports->about = $request->about;
        $reports->description = $request->description;
        $reports->nik_id = $request->nik_id;

        $reports->save();

        echo "Sukses";
    }

}
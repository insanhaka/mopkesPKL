<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Simkl;
use App\Market;
use App\Stalllocation;
use App\Seller;

class HomeController extends Controller
{
    public function index()
    {
        $data['markets'] = Market::all();
        $data['stalls'] = Stalllocation::all();
        $data['sellers'] = Seller::all();
        if (\Request::ajax()) {
            $view = view('frontend.home',compact('data'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('frontend.home',compact('data'))->render();
    }

    public function statsCommodities()
    {
        $jmlCommodities = Simkl::selectRaw('commodity_id, count(id) total')
            ->groupBy('commodity_id')
            ->orderBy('commodity_id')
            ->get();

        $labels = array();
        $values = array();
        foreach ($jmlCommodities as $jmlC) {
            array_push($labels, $jmlC->commodity->name);
            array_push($values, $jmlC->total);
        }
        $data['labels'] = $labels;
        $data['values'] = $values;
        return response()->json($data);
    }

    public function statsDomicile()
    {
        $jmlDomicile = Simkl::selectRaw('seller_id, count(id) total')
            ->groupBy('seller_id')
            ->orderBy('seller_id')
            ->get();

        $labels = array();
        $values = array();
        foreach ($jmlDomicile as $jmlD) {
            array_push($labels, $jmlD->seller->district->name);
            array_push($values, $jmlD->total);
        }
        $data['labels'] = $labels;
        $data['values'] = $values;
        return response()->json($data);
    }
}

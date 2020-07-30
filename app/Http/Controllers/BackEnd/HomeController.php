<?php

namespace App\Http\Controllers\BackEnd;

use App\Agreement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Report;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        $data = Report::orderBy('count', 'desc')->select(DB::raw('nik_id,count(*) as count'))->groupBy('nik_id')->get();

        $agreement = Agreement::all();

        if (\Request::ajax()) {
            $view = view('backend.home', compact('data', 'agreement'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.home', compact('data', 'agreement'))->render();
    }
}

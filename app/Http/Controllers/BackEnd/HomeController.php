<?php

namespace App\Http\Controllers\BackEnd;

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
        if (\Request::ajax()) {
            $view = view('backend.home', compact('data'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.home', compact('data'))->render();
    }
}

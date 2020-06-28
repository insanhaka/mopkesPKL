<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Seller;

class ReportController extends Controller
{
     public function __construct(){}

    public function index()
    {
        $reports = Report::all();
        if (\Request::ajax()) {
            $view = view('backend.reports.index', compact('reports'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.reports.index', compact('reports'))->render();
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

   public function delete(Request $request)
    {
        $ids = $request->id;
        if (is_array($ids)) {
            $status = Product::destroy($ids);
        } else {
            $status = Product::findOrFail($ids)->delete();
        }
        if ($status) {
            $data['status'] = true;
            $data['message'] = "Data berhasil dihapus!!!";
        } else {
            $data['status'] = false;
            $data['message'] = "Data gagal dihapus!!!";
        }
        return response()->json(['code' => 200,'data' => $data], 200);
    }
}
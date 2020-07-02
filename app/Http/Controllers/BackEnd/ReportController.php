<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;
use App\Sector;

class ReportController extends Controller
{
     public function __construct(){}

    public function index()
    {
        $reports = Report::all()->sortByDesc('created_at');

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
        $product = Sector::findOrFail($id);

        return response()->json($product);
    }

    public function delete($id)
    {
        $data = Report::find($id);
        $data->delete();
        return back()->with('warning','Data Berhasil Dihapus');
    }

//    public function delete(Request $request)
//     {
//         $ids = $request->id;
//         if (is_array($ids)) {
//             $status = Product::destroy($ids);
//         } else {
//             $status = Product::findOrFail($ids)->delete();
//         }
//         if ($status) {
//             $data['status'] = true;
//             $data['message'] = "Data berhasil dihapus!!!";
//         } else {
//             $data['status'] = false;
//             $data['message'] = "Data gagal dihapus!!!";
//         }
//         return response()->json(['code' => 200,'data' => $data], 200);
//     }
}

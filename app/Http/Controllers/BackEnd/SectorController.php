<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sector;

class SectorController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $sectors = Sector::all();
        if (\Request::ajax()) {
            $view = view('backend.sectors.index', compact('sectors'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sectors.index', compact('sectors'))->render();
    }

    public function create()
    {
        if (\Request::ajax()) {
            $view = view('backend.sectors.create')->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sectors.create')->render();
    }

    public function store(Request $request)
    {
        $status = Sector::create($request->all());
        if ($status) {
            $data['status'] = true;
            $data['message'] = "Data berhasil disimpan!!!";
        } else {
            $data['status'] = false;
            $data['message'] = "Data gagal disimpan!!!";
        }
        return response()->json(['code' => 200,'data' => $data], 200);
    }

    public function show($id)
    {
        $sector = Sector::findOrFail($id);

        return response()->json($sector);
    }

    public function edit($id)
    {
        $sector = Sector::findOrFail($id);
        if (\Request::ajax()) {
            $view = view('backend.sectors.edit', compact('sector'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sectors.edit', compact('sector'));
    }

    public function update(Request $request, $id)
    {
        $sector = Sector::findOrFail($id);
        $status = $sector->update($request->all());

        if ($status) {
            $data['status'] = true;
            $data['message'] = "Data berhasil disimpan!!!";
        } else {
            $data['status'] = false;
            $data['message'] = "Data gagal disimpan!!!";
        }
        return response()->json(['code' => 200,'data' => $data], 200);
    }

    public function delete($id)
    {
        $data = Sector::find($id);
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

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kelompok;

class KelompokController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $kelompoks = Kelompok::all();
        if (\Request::ajax()) {
            $view = view('backend.kelompoks.index', compact('kelompoks'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.kelompoks.index', compact('kelompoks'))->render();
    }

    public function create()
    {
        if (\Request::ajax()) {
            $view = view('backend.kelompoks.create')->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.kelompoks.create')->render();
    }

    public function store(Request $request)
    {
        $status = Kelompok::create($request->all());
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
        $kelompok = Kelompok::findOrFail($id);

        return response()->json($kelompok);
    }

    public function edit($id)
    {
        $kelompok = Kelompok::findOrFail($id);
        if (\Request::ajax()) {
            $view = view('backend.kelompoks.edit', compact('kelompok'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.kelompoks.edit', compact('kelompok'));
    }

    public function update(Request $request, $id)
    {
        $kelompok = Kelompok::findOrFail($id);
        $status = $kelompok->update($request->all());

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
        $data = Kelompok::find($id);
        $data->delete();
        return back()->with('warning','Data Berhasil Dihapus');
    }

    // public function delete(Request $request)
    // {
    //     $ids = $request->id;
    //     if (is_array($ids)) {
    //         $status = Kelompok::destroy($ids);
    //     } else {
    //         $status = Kelompok::findOrFail($ids)->delete();
    //     }
    //     if ($status) {
    //         $data['status'] = true;
    //         $data['message'] = "Data berhasil dihapus!!!";
    //     } else {
    //         $data['status'] = false;
    //         $data['message'] = "Data gagal dihapus!!!";
    //     }
    //     return response()->json(['code' => 200,'data' => $data], 200);
    // }
}

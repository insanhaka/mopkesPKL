<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Community;
use App\District;

class CommunityController extends Controller
{
    public function __construct(){
        $this->kecparent = District::where('regency_id', 3328)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kecamatan', 0);
    }

    public function index()
    {
        $communities = Community::all();
        if (\Request::ajax()) {
            $view = view('backend.communities.index', compact('communities'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.communities.index', compact('communities'))->render();
    }

    public function create()
    {
        $kecparent = $this->kecparent;
        if (\Request::ajax()) {
            $view = view('backend.communities.create', compact('kecparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.communities.create', compact('kecparent'))->render();
    }

    public function store(Request $request)
    {
        $status = Community::create($request->all());
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
        $communities = Community::findOrFail($id);

        return response()->json($communities);
    }

    public function edit($id)
    {
        $communities = Community::findOrFail($id);
        $kecparent = $this->kecparent;
        if (\Request::ajax()) {
            $view = view('backend.communities.edit', compact('communities', 'kecparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.communities.edit', compact('communities', 'kecparent'));
    }

    public function update(Request $request, $id)
    {
        $communities = Community::findOrFail($id);
        $status = $communities->update($request->all());

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
        $data = Community::find($id);
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

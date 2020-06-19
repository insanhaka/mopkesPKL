<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agreement;

class AgreementController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $agreements = Agreement::all();
        if (\Request::ajax()) {
            $view = view('backend.agreements.index', compact('agreements'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.index', compact('agreements'))->render();
    }

    public function create()
    {
        if (\Request::ajax()) {
            $view = view('backend.agreements.create')->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.create')->render();
    }

    public function store(Request $request)
    {

        $this->validate($request, [
			'attachment' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
			'name' => 'required',
		]);

		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('attachment');

		$nama_file = time()."_".$file->getClientOriginalName();

      	        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_file';
		$file->move($tujuan_upload,$nama_file);

		$status =  Agreement::create([
			'attachment' => $nama_file,
			'name' => $request->name,
        ]);

        // $setuju = new Agreement();
        // $setuju->name = $request->name;
        // $setuju->attachment = $request->attachment;
        // $status = $setuju->save();
        // $status = Agreement::create($request->all());
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
        $agreement = Agreement::findOrFail($id);

        return response()->json($agreement);
    }

    public function edit($id)
    {
        $agreement = Agreement::findOrFail($id);
        if (\Request::ajax()) {
            $view = view('backend.agreements.edit', compact('agreement'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.edit', compact('agreement'));
    }

    public function update(Request $request, $id)
    {
        $agreement = Agreement::findOrFail($id);
        $status = $agreement->update($request->all());

        if ($status) {
            $data['status'] = true;
            $data['message'] = "Data berhasil disimpan!!!";
        } else {
            $data['status'] = false;
            $data['message'] = "Data gagal disimpan!!!";
        }
        return response()->json(['code' => 200,'data' => $data], 200);
    }

    public function delete(Request $request)
    {
        $ids = $request->id;
        if (is_array($ids)) {
            $status = Agreement::destroy($ids);
        } else {
            $status = Agreement::findOrFail($ids)->delete();
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

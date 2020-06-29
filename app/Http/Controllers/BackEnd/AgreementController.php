<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agreement;
use App\Kelompok;

class AgreementController extends Controller
{
    public function __construct(){
        $this->kelompokparent = Kelompok::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kelompok', '');
    }

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
        $kelompokparent = $this->kelompokparent;
        if (\Request::ajax()) {
            $view = view('backend.agreements.create', compact('kelompokparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.create', compact('kelompokparent'))->render();
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $data_kelompok = $request->menu_kelompok;
        // dd($data_kelompok);

        $this->validate($request, [
			'attachment' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'nik' => 'required',
            'menu_kelompok' => 'required'
			// 'attachment' => 'required',
        ]);

        if ($data_kelompok === "Kelompok"){

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('attachment');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'agreement_file';
            $file->move($tujuan_upload,$nama_file);

            $input =  Agreement::create([
                'attachment' => $nama_file,
                'status' => $data_kelompok,
                'name' => $request->name,
                'nik' => $request->nik,
                'kelompok_id' => $request->kelompok_id,
            ]);

            return redirect(url()->current())->with('success','Data Berhasil Disimpan');

        } else {

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('attachment');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'agreement_file';
            $file->move($tujuan_upload,$nama_file);

            $input =  Agreement::create([
                'attachment' => $nama_file,
                'status' => $data_kelompok,
                'name' => $request->name,
                'nik' => $request->nik,
                'kelompok_id' => $request->kelompok_id,
            ]);

            return redirect(url()->current())->with('success','Data Berhasil Disimpan');

        }

    }

    public function show()
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

    public function edit($id)
    {
        $agreement = Agreement::findOrFail($id);
        $kelompokparent = $this->kelompokparent;
        if (\Request::ajax()) {
            $view = view('backend.agreements.edit', compact('agreement', 'kelompokparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.edit', compact('agreement', 'kelompokparent'));
    }

    public function update(Request $request, $id)
    {

        $data_kelompok = $request->menu_kelompok;

        $this->validate($request, [
			'attachment' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'menu_kelompok' => 'required'
			// 'attachment' => 'required',
        ]);

        if ($data_kelompok === "Kelompok"){

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('attachment');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'agreement_file';
            $file->move($tujuan_upload,$nama_file);

            // $input =  Agreement::create([
            //     'attachment' => $nama_file,
            //     'status' => 'Kelompok',
            //     'name' => $request->name,
            // ]);

            // $status = Kelompok::create([
            //     'name' => $request->name,
            // ]);

            $data = Agreement::find($id);
            $data->name = $request->name;
            $data->status = $data_kelompok;
            $data->kelompok_id = $request->kelompok_id;
            $data->attachment = $nama_file;
            $data->save();

            $url = url()->current();
            $fixurl = str_replace( array( $id ), ' ', $url);

            return redirect($fixurl)->with('success','Data Berhasil Disimpan');

        } else {

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('attachment');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'agreement_file';
            $file->move($tujuan_upload,$nama_file);

            $data = Agreement::find($id);
            $data->name = $request->name;
            $data->status = $data_kelompok;
            $data->kelompok_id = $request->kelompok_id;
            $data->attachment = $nama_file;
            $data->save();

            $url = url()->current();
            $fixurl = str_replace( array( $id ), ' ', $url);

            return redirect($fixurl)->with('success','Data Berhasil Disimpan');

        }
    }

    public function delete($id)
    {
        $data = Agreement::find($id);
        $data->delete();
        return back()->with('warning','Data Berhasil Dihapus');
    }

    // public function delete(Request $request)
    // {
    //     $ids = $request->id;
    //     if (is_array($ids)) {
    //         $status = Menu::destroy($ids);
    //     } else {
    //         $status = Menu::findOrFail($ids)->delete();
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

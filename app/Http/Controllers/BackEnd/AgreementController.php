<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agreement;
use App\Community;
use DB;

class AgreementController extends Controller
{
    public function __construct(){
        $this->communitiesparent = Community::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kelompok', '');
    }

    public function index()
    {
        $agreements = Agreement::all();

        // dd($agreements);

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
        $communitiesparent = $this->communitiesparent;
        if (\Request::ajax()) {
            $view = view('backend.agreements.create', compact('communitiesparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.create', compact('communitiesparent'))->render();
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $data_communities = $request->menu_communities;
        // dd($data_kelompok);

        $this->validate($request, [
			'attachment' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'nik' => 'required',
            'menu_communities' => 'required'
			// 'attachment' => 'required',
        ]);

        if ($data_communities === "Kelompok"){

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('attachment');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'agreement_file';
            $file->move($tujuan_upload,$nama_file);

            $input =  Agreement::create([
                'attachment' => $nama_file,
                'status' => $data_communities,
                'name' => $request->name,
                'nik' => $request->nik,
                'community_id' => $request->community_id,
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
                'status' => $data_communities,
                'name' => $request->name,
                'nik' => $request->nik,
                'community_id' => $request->community_id,
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
        $communitiesparent = $this->communitiesparent;
        if (\Request::ajax()) {
            $view = view('backend.agreements.edit', compact('agreement', 'communitiesparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.edit', compact('agreement', 'communitiesparent'));
    }

    public function update(Request $request, $id)
    {

        $data_communities = $request->menu_communities;

        $this->validate($request, [
            'attachment' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            // 'attachment' => 'required|mimes:pdf,xlx,csv',
            'name' => 'required',
            'menu_communities' => 'required'
			// 'attachment' => 'required',
        ]);

        if ($data_communities === "Kelompok"){

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
            $data->status = $data_communities;
            $data->community_id = $request->community_id;
            $data->attachment = $nama_file;
            $data->save();

            // $url = url()->current();
            // $fixurl = str_replace( array( $id ), ' ', $url);

            return redirect(url('/admin/agreement'))->with('success','Data Berhasil Disimpan');

        } else {

            // menyimpan data file yang diupload ke variabel $file
            $file = $request->file('attachment');

            $nama_file = time()."_".$file->getClientOriginalName();

                    // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'agreement_file';
            $file->move($tujuan_upload,$nama_file);

            $data = Agreement::find($id);
            $data->name = $request->name;
            $data->status = $data_communities;
            $data->community_id = $request->community_id;
            $data->attachment = $nama_file;
            $data->save();

            // $url = url()->current();
            // $fixurl = str_replace( array( $id ), ' ', $url);

            return redirect(url('/admin/agreement'))->with('success','Data Berhasil Disimpan');

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

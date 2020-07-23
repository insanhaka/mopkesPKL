<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Agreement;
use App\Community;
use App\Province;
use App\District;
use DB;

class AgreementController extends Controller
{
    public function __construct(){
        $this->communitiesparent = Community::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kelompok', '');
        $this->kecparent = District::where('regency_id', 3328)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kecamatan', 0);
        $this->provparent = Province::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Provinsi', 0);
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
        $provparent = $this->provparent;
        $kecparent = $this->kecparent;
        if (\Request::ajax()) {
            $view = view('backend.agreements.create', compact('communitiesparent', 'provparent', 'kecparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.create', compact('communitiesparent', 'provparent', 'kecparent'))->render();
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
            // 'menu_communities' => 'required'
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
                'name' => $request->name,
                'nik' => $request->nik,
                'ktp_prov' => $request->ktp_prov,
                'ktp_kab' => $request->ktp_kab,
                'ktp_kec' => $request->ktp_kec,
                'ktp_desa' => $request->ktp_desa,
                'ktp_addr' => $request->ktp_addr,
                'domisili_prov' => $request->domisili_prov,
                'domisili_kab' => $request->domisili_kab,
                'domisili_kec' => $request->domisili_kec,
                'domisili_desa' => $request->domisili_desa,
                'domisili_addr' => $request->domisili_addr,
                'status' => $data_communities,
                'community_id' => $request->community_id,
                'attachment' => $nama_file,
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
                'name' => $request->name,
                'nik' => $request->nik,
                'ktp_prov' => $request->ktp_prov,
                'ktp_kab' => $request->ktp_kab,
                'ktp_kec' => $request->ktp_kec,
                'ktp_desa' => $request->ktp_desa,
                'ktp_addr' => $request->ktp_addr,
                'domisili_prov' => $request->domisili_prov,
                'domisili_kab' => $request->domisili_kab,
                'domisili_kec' => $request->domisili_kec,
                'domisili_desa' => $request->domisili_desa,
                'domisili_addr' => $request->domisili_addr,
                'status' => $data_communities,
                'community_id' => $request->community_id,
                'attachment' => $nama_file,
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
        $provparent = $this->provparent;
        $kecparent = $this->kecparent;
        if (\Request::ajax()) {
            $view = view('backend.agreements.edit', compact('agreement', 'communitiesparent', 'provparent', 'kecparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.agreements.edit', compact('agreement', 'communitiesparent', 'provparent', 'kecparent'));
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

            $data = Agreement::find($id);
            $data->name = $request->name;
            $data->status = $data_communities;
            $data->community_id = $request->community_id;
            $data->attachment = $nama_file;
            $data->save();

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

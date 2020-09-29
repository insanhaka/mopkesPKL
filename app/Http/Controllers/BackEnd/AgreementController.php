<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Agreement;
use App\Community;
use App\Province;
use App\District;
use DataTables;

class AgreementController extends Controller
{
    public function __construct(){
        $this->communitiesparent = Community::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kelompok', '');
        $this->kecparent = District::where('regency_id', 3328)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kecamatan', 0);
        $this->provparent = Province::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Provinsi', 0);
    }

    public function index()
    {
        $agreements = Agreement::orderBy('name', 'asc')->get();

        // foreach ($agreements as $value) {
        //     $data[] = $value->name;
        // }

        // dd($data);

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

    public function getDataServerSide(Request $request)
    {
       
        $data = Agreement::orderBy('name', 'asc')->get();
        return Datatables::of($data)
                ->addColumn('checkall', function ($data) {
                    $checkall = '<td class="text-center" width="50px">
                                    <input class="cekbox" name="del[]" type="checkbox" value="'.$data->id.'" id="cek'.$data->id.'">
                                </td>' ;
                    return $checkall;
                })
                ->addColumn('ktp', function ($data) {
                    $ktp_addr = '<td>DESA '.$data->village_ktp->name.', KEC. '.$data->district_ktp->name.'</td>';
                    return $ktp_addr;
                })
                ->addColumn('domisili', function ($data) {
                    $domisili_addr = '<td>DESA '.$data->village_dom->name.', KEC. '.$data->district_dom->name.'</td>';
                    return $domisili_addr;
                })
                ->addColumn('nama-kelompok', function ($data) {
                    if($data->status === "Kelompok"){
                        $nama_kelompok = '<td>'.$data->community->name.'</td>';
                    }else{
                        $nama_kelompok = '<td> ---- </td>';
                    }
                    return $nama_kelompok;
                })
                ->addColumn('attachment', function ($data) {
                    $pict = '<td><img src="/agreement_file/'.$data->attachment.'" class="card-img-top" style="width: 50px; height: 50px;" alt="..."></td>' ;
                    return $pict;
                })
                ->addColumn('viewlink', function ($data) {
                    $view = '<a href="/agreement_file/'.$data->attachment.'" alt="Image description" target="_blank" style="display: inline-block; width: 100%; height: 100%;">Preview</a>' ;
                    return $view;
                })
                ->addColumn('act', function ($data) {
                    $checkall = '<div class="dropdown d-inline">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>
                        <div class="dropdown-menu">'
                        .\GHelper::btnEdit($data->id)
                        .\GHelper::btnDelete($data->id)
                        .'</div>
                    </div>';
                    return $checkall;
                })->rawColumns(['checkall','ktp','domisili','nama-kelompok','attachment','viewlink','act'])
                ->make(true);
        
        // return view('users');
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
        if (Agreement::where('nik', $request->nik)->exists()) {
            return back()->with(['failnik' => 'NIK yang anda tulis sudah ada pada database']);
        }else{
            $data_communities = $request->menu_communities;
            $this->validate($request, [
                'attachment' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required',
                'nik' => 'required',
            ]);

            if ($data_communities === "Kelompok"){
                $validator = Validator::make( $request->all(), [
                    'community_id' => 'required',
                ]);
                if ($validator->fails()) {
                    return back()->with(['failkel' => 'Jika Memilih "Kelompok" maka Nama kelompok harus diisi']);
                }else {
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
            $data->nik = $request->nik;
            $data->ktp_prov = $request->ktp_prov;
            $data->ktp_kab = $request->ktp_kab;
            $data->ktp_kec = $request->ktp_kec;
            $data->ktp_desa = $request->ktp_desa;
            $data->ktp_addr = $request->ktp_addr;
            $data->domisili_prov = $request->domisili_prov;
            $data->domisili_kab = $request->domisili_kab;
            $data->domisili_kec = $request->domisili_kec;
            $data->domisili_desa = $request->domisili_desa;
            $data->domisili_addr = $request->domisili_addr;
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
            $data->nik = $request->nik;
            $data->ktp_prov = $request->ktp_prov;
            $data->ktp_kab = $request->ktp_kab;
            $data->ktp_kec = $request->ktp_kec;
            $data->ktp_desa = $request->ktp_desa;
            $data->ktp_addr = $request->ktp_addr;
            $data->domisili_prov = $request->domisili_prov;
            $data->domisili_kab = $request->domisili_kab;
            $data->domisili_kec = $request->domisili_kec;
            $data->domisili_desa = $request->domisili_desa;
            $data->domisili_addr = $request->domisili_addr;
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

    public function delall(Request $request)
    {

        $ids = $request->del;
        if (is_array($ids)) {
            $status = Agreement::destroy($ids);
        } else {
            $status = Agreement::findOrFail($ids)->delete();
        }
        if ($status) {
            return back()->with('warning','Data Berhasil Dihapus');
        } else {
            return back()->with('error','Data Berhasil Dihapus');
        }
    }


}

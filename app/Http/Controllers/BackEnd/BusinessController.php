<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business;
use App\Province;
use App\Sector;
use App\Agreement;
use App\District;
use App\Village;
use DB;
use PDF;
use DataTables;
use Illuminate\Support\Facades\Input;

class BusinessController extends Controller
{
    public function __construct(){
        $this->kecparent = District::where('regency_id', 3328)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kecamatan', 0);
        $this->desparent = Village::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Desa', 0);
        $this->sectorparent = Sector::where('sector_name', 0)->orderBy('sector_name', 'asc')->pluck('sector_name', 'id')->prepend('Pilih Sektor', 0);
        // $this->nikparent = Agreement::leftJoin('business', 'nik', '=', 'nik_id')->whereNull('nik_id')->pluck('nik', 'nik')->prepend('NIK', '');
        $this->nikparent = Agreement::get(['id', 'nik'])->pluck('nik', 'id')->prepend('NIK', '');
        $this->provparent = Province::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Provinsi', 0);
    }

    public function index()
    {
        $business = Business::all();
        $agreement = Agreement::orderBy('name', 'asc')->get();
        $totbusiness = Business::groupBy('nik_id')->select('nik_id', \DB::raw('count(*) as total'))->get();
        if (\Request::ajax()) {
            $view = view('backend.business.index', compact('business', 'agreement', 'totbusiness'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.business.index', compact('business', 'agreement', 'totbusiness'))->render();
    }

    public function getDataServerSide()
    {       
        $data = Business::orderBy('name', 'asc')->get();
        return Datatables::of($data)
                ->addColumn('checkall', function ($data) {
                    $checkall = '<td class="text-center" width="50px">
                                    <input class="cekbox" name="del[]" type="checkbox" value="'.$data->id.'" id="cek'.$data->id.'">
                                </td>' ;
                    return $checkall;
                })
                ->addColumn('nik', function ($data) {
                    $get_nik = Agreement::where('id', $data->nik_id)->first();
                    $nik = '<td>'.$get_nik->nik.'</td>' ;
                    return $nik;
                })
                ->addColumn('ktp', function ($data) {
                    $get_ktp = Agreement::where('id', $data->nik_id)->first();
                    $ktp = 'DESA '.$get_ktp->village_ktp->name.', KEC. '.$get_ktp->district_ktp->name.'' ;
                    return $ktp;
                })
                ->addColumn('domisili', function ($data) {
                    $get_dom = Agreement::where('id', $data->nik_id)->first();
                    $dom = 'DESA '.$get_dom->village_dom->name.', KEC. '.$get_dom->district_dom->name.'' ;
                    return $dom;
                })
                ->addColumn('view', function ($data) {
                    $get = Agreement::where('id', $data->nik_id)->first();
                    $view_data = '<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#bisnis'.$get->id.'">view</button>';
                    return $view_data;
                })->rawColumns(['checkall','nik','ktp','domisili','total','view'])
                ->make(true);
        
        // return view('users');
    }

    public function create()
    {
        $kecparent = $this->kecparent;
        $desparent = $this->desparent;
        $sectorparent = $this->sectorparent;
        $nikparent = $this->nikparent;
        if (\Request::ajax()) {
            $view = view('backend.business.create', compact('kecparent', 'desparent', 'sectorparent', 'nikparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.business.create', compact('kecparent', 'desparent', 'sectorparent', 'nikparent'))->render();
    }

    public function store(Request $request)
    {

        // dd($request->all());

        // $this->validate($request, [
        //     'photo' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        // ]);

        // $file = $request->file('photo');
        // dd($file);

        $datakelompok = Agreement::where('nik', $request->nik_id)->first();

        $databusiness = new Business;
        $databusiness->name = $request->name;
        $databusiness->nik_id = $datakelompok->id;
        $databusiness->lapak_kec = $request->lapak_kec;
        $databusiness->lapak_desa = $request->lapak_desa;
        $databusiness->lapak_addr = $request->lapak_addr;
        $databusiness->sector_id = $request->sector_id;
        $databusiness->business_name = $request->business_name;
        $databusiness->mulai_jual = $request->mulai_jual;
        $databusiness->selesai_jual = $request->selesai_jual;
        $databusiness->contact = $request->contact;
        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('photo');
        if($file == null){
            $nama_file = "";
            $databusiness->photo = $nama_file;
        }else{
            $nama_file = time()."_".$file->getClientOriginalName();
            // isi dengan nama folder tempat kemana file diupload
            $tujuan_upload = 'foto_usaha';
            $file->move($tujuan_upload,$nama_file);
            $databusiness->photo = $nama_file;
        }
        if($datakelompok->community_id == null){
            $databusiness->status_kelompok = "Tidak";
        }else {
            $databusiness->status_kelompok = "Ya";
        }
        $databusiness->is_active = 1;
        $databusiness->community_id = $datakelompok->community_id;

        $status = $databusiness->save();

        return redirect(url()->current())->with('success','Data Berhasil Disimpan');
    }

    public function show($id)
    {
        $business = Business::findOrFail($id);

        return response()->json($business);
    }

    public function edit($id)
    {
        $business = Business::findOrFail($id);
        $provparent = $this->provparent;
        $kecparent = $this->kecparent;
        $sectorparent = $this->sectorparent;
        $nikparent = $this->nikparent;
        if (\Request::ajax()) {
            $view = view('backend.business.edit', compact('business', 'kecparent', 'provparent', 'sectorparent', 'nikparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.business.edit', compact('business', 'kecparent', 'provparent', 'sectorparent', 'nikparent'));
    }

    public function update(Request $request, $id)
    {

        // dd($request);

        $this->validate($request, [
            'photo' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('photo');

        $nama_file = time()."_".$file->getClientOriginalName();

                // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'foto_usaha';
        $file->move($tujuan_upload,$nama_file);

        // $business = Business::findOrFail($id);
        // dd($business);
        $databusiness = Business::find($id);
        $databusiness->lapak_kec = $request->lapak_kec;
        $databusiness->lapak_desa = $request->lapak_desa;
        $databusiness->lapak_addr = $request->lapak_addr;
        $databusiness->sector_id = $request->sector_id;
        $databusiness->business_name = $request->business_name;
        $databusiness->mulai_jual = $request->mulai_jual;
        $databusiness->selesai_jual = $request->selesai_jual;
        $databusiness->contact = $request->contact;
        $databusiness->photo = $nama_file;

        $databusiness->save();

        // $business->update($request->all());

        return redirect(url('/admin/business'))->with('success','Data Berhasil Disimpan');
    }

    public function delete($id)
    {
        $data = Business::find($id);
        $data->delete();
        return back()->with('warning','Data Berhasil Dihapus');
    }

    public function generate($id)
    {

        $pedagang = DB::table('business')
                ->join('agreements', 'business.nik_id', '=', 'agreements.nik')
                ->where('business.id', '=', $id)
                ->get();

                // dd($pedagang);

        return view('backend.business.qrcode', ['pedagang' => $pedagang]);
    }

    public function qrall(Request $request)
    {
        $ids = $request->generate;
        // dd($ids);
        // $generate = Business::findOrFail($ids);

        $generate = Business::whereIn('id', $ids)->get();
        // dd($generate);

        return view('backend.business.qrcode', ['pedagang' => $generate]);

    }

    public function dellall(Request $request)
    {
        $ids = $request->del;

        $data = Business::whereIn('nik_id', $ids)->delete();

        return back()->with('warning','Data Berhasil Dihapus');

    }


}

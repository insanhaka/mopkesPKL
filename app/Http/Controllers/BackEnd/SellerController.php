<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Seller;
use App\District;
use App\Kelompok;
use App\Product;
use App\Village;
use App\Agreement;

class SellerController extends Controller
{
    public function __construct(){
        $this->kecparent = District::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kecamatan', 0);
        $this->desparent = Village::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Desa', 0);
        $this->productparent = Product::where('product_name', 0)->orderBy('product_name', 'asc')->pluck('product_name', 'id')->prepend('Pilih Produk', 0);
        // $this->kelompokparent = Kelompok::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'id')->prepend('Pilih Kelompok', '');
        $this->nikparent = Agreement::where('nik', 0)->orderBy('nik', 'asc')->pluck('nik', 'id')->prepend('NIK', '');
    }

    public function index()
    {
        $sellers = Seller::all();
        if (\Request::ajax()) {
            $view = view('backend.sellers.index', compact('sellers'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sellers.index', compact('sellers'))->render();
    }

    public function create()
    {
        $kecparent = $this->kecparent;
        $desparent = $this->desparent;
        $productparent = $this->productparent;
        // $kelompokparent = $this->kelompokparent;
        $nikparent = $this->nikparent;
        if (\Request::ajax()) {
            $view = view('backend.sellers.create', compact('kecparent', 'desparent', 'productparent', 'nikparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sellers.create', compact('kecparent', 'desparent', 'productparent', 'nikparent'))->render();
    }

    public function store(Request $request)
    {

        // dd($request->all());

        // $datakelompok = Kelompok::find()

        $dataseller = new Seller;
        $dataseller->name = $request->name;
        $dataseller->nik = $request->nik;
        $dataseller->domisili_kec = $request->domisili_kec;
        $dataseller->domisili_desa = $request->domisili_desa;
        $dataseller->domisili_addr = $request->domisili_addr;
        $dataseller->ktp_kec = $request->ktp_kec;
        $dataseller->ktp_desa = $request->ktp_desa;
        $dataseller->ktp_addr = $request->ktp_addr;
        $dataseller->lapak_kec = $request->lapak_kec;
        $dataseller->lapak_desa = $request->lapak_desa;
        $dataseller->lapak_addr = $request->lapak_addr;
        $dataseller->product_id = $request->product_id;
        $dataseller->product_specific = $request->product_specific;
        $dataseller->waktu_jual = $request->waktu_jual;
        $dataseller->status_kelompok = $request->status_kelompok;
        $dataseller->kelompok_id = $request->kelompok_id;

        $status = $dataseller->save();
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
        $seller = Seller::findOrFail($id);

        return response()->json($seller);
    }

    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        if (\Request::ajax()) {
            $view = view('backend.sellers.edit', compact('seller'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sellers.edit', compact('seller'));
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        $status = $seller->update($request->all());

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
            $status = Seller::destroy($ids);
        } else {
            $status = Seller::findOrFail($ids)->delete();
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

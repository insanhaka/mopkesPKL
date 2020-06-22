<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Seller;
use App\District;
use App\Product;
use App\Village;

class SellerController extends Controller
{
    public function __construct(){
        $this->kecparent = District::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'name')->prepend('Pilih Kecamatan', '0');
        $this->desparent = Village::where('name', 0)->orderBy('name', 'asc')->pluck('name', 'name')->prepend('Pilih Desa', '0');
        $this->productparent = Product::where('product_name', 0)->orderBy('product_name', 'asc')->pluck('product_name', 'product_name')->prepend('Pilih Produk', '0');
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
        if (\Request::ajax()) {
            $view = view('backend.sellers.create', compact('kecparent', 'desparent', 'productparent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.sellers.create', compact('kecparent', 'desparent', 'productparent'))->render();
    }

    public function store(Request $request)
    {
        $status = Seller::create($request->all());
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

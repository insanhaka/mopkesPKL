<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $products = Product::all();
        if (\Request::ajax()) {
            $view = view('backend.products.index', compact('products'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.products.index', compact('products'))->render();
    }

    public function create()
    {
        if (\Request::ajax()) {
            $view = view('backend.products.create')->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.products.create')->render();
    }

    public function store(Request $request)
    {
        $status = Product::create($request->all());
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
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        if (\Request::ajax()) {
            $view = view('backend.products.edit', compact('product'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $status = $product->update($request->all());

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
            $status = Product::destroy($ids);
        } else {
            $status = Product::findOrFail($ids)->delete();
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
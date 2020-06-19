<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Permission;
use App\Menu;

class PermissionController extends Controller
{
    public function __construct(){
        $this->arrMenuChild = Menu::where('menu_parent','!=', 0)->orderBy('menu_name', 'asc')->pluck('menu_name', 'id')->prepend('-- Pilih Menu --', '');
    }

    public function index()
    {
        // $permissions = Permission::all();
        if (\Request::ajax()) {
            $view = view('backend.permissions.index')->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.permissions.index')->render();
    }

    public function getDataServerSide()
    {
        $data = Permission::all();
        return Datatables::of($data)
            ->addColumn('checkall', function ($data) {
                $checkall = \GHelper::cbDelete($data->id);
                return $checkall;
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
            })->rawColumns(['checkall','act'])
            ->make(true);
    }

    public function create()
    {
        $arrMenuChild = $this->arrMenuChild;
        if (\Request::ajax()) {
            $view = view('backend.permissions.create',compact('arrMenuChild'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.permissions.create',compact('arrMenuChild'))->render();
    }

    public function store(Request $request)
    {
        $status = Permission::create($request->all());
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
        $permission = Permission::findOrFail($id);

        return response()->json($permission);
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $arrMenuChild = $this->arrMenuChild;
        if (\Request::ajax()) {
            $view = view('backend.permissions.edit', compact('permission','arrMenuChild'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.permissions.edit', compact('permission','arrMenuChild'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $status = $permission->update($request->all());

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
            $status = Permission::destroy($ids);
        } else {
            $status = Permission::findOrFail($ids)->delete();
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
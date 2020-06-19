<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\Permission;

class MenuController extends Controller
{
    public function __construct(){
        $this->arrMenuParent = Menu::where('menu_parent', 0)->orderBy('menu_name', 'asc')->pluck('menu_name', 'id')->prepend('-- ROOT --', '0');
    }

    public function index()
    {
        $menus = Menu::all();
        if (\Request::ajax()) {
            $view = view('backend.menus.index', compact('menus'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.menus.index', compact('menus'))->render();
    }

    public function create()
    {
        $arrMenuParent = $this->arrMenuParent;
        if (\Request::ajax()) {
            $view = view('backend.menus.create',compact('arrMenuParent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.menus.create',compact('arrMenuParent'))->render();
    }

    public function store(Request $request)
    {
        // Start transaction
        \DB::transaction(function () use ($request) {
            // Run Queries
            $dataMenu = [
                'menu_parent' => $request->menu_parent,
                'menu_name' => $request->menu_name,
                'menu_uri' => $request->menu_uri,
                'menu_target' => $request->menu_target,
                'menu_group' => $request->menu_group,
                'menu_active' => ($request->menu_active == 1) ? 1 : 0,
                'menu_icon' => $request->menu_icon,
                'created_by' => \Auth::user()->username
            ];
            $dtMenu = Menu::create($dataMenu);
            $menu_actions = $request->menu_action;
            $actions = [];
            foreach ($menu_actions as $mn_action) { //$intersts array contains input data
                $actions[] = [
                    'menu_id' => $dtMenu->id,
                    'permission_name' => strtolower($request->menu_uri) . '-' . $mn_action,
                    'permission_description' => 'Allow Access ' . $request->menu_name . ' ' . $mn_action,
                    'created_by' => \Auth::user()->username,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            $newPermission = Permission::insert($actions);
            if ($dtMenu->wasRecentlyCreated && $newPermission) {
                $data['status'] = true;
                $data['message'] = "Data berhasil disimpan!!!";
            } else {
                $data['status'] = false;
                $data['message'] = "Data gagal disimpan!!!";
            }
            echo json_encode(['code' => 200,'data' => $data], 200);
        });
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        return response()->json($menu);
    }

    public function edit($id)
    {
        $arrMenuParent = $this->arrMenuParent;
        $menu = Menu::findOrFail($id);
        if (\Request::ajax()) {
            $view = view('backend.menus.edit', compact('menu','arrMenuParent'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.menus.edit', compact('menu','arrMenuParent'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $status = $menu->update($request->all());
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
            $status = Menu::destroy($ids);
        } else {
            $status = Menu::findOrFail($ids)->delete();
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

    public function geturimenu(Request $request){
        $uri = Menu::find($request->menu_id, ['menu_uri']);
        return response()->json(['code' => 200,'uri' => $uri], 200);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $roles = Role::all();
        if (\Request::ajax()) {
            $view = view('backend.roles.index', compact('roles'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.roles.index', compact('roles'))->render();
    }

    public function create()
    {
        if (\Request::ajax()) {
            $view = view('backend.roles.create')->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.roles.create')->render();
    }

    public function store(Request $request)
    {
        $status = Role::create($request->all());
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
        $role = Role::findOrFail($id);

        return response()->json($role);
    }

    public function edit($id)
    {
        $data['role'] = Role::findOrFail($id);
        // Permission Modules
        $permissions = Permission::select(\DB::raw("LEFT(permission_name,LENGTH(permission_name) - locate('-',REVERSE(permission_name))) as name"),'menu_id')->groupBy(\DB::raw("LEFT(permission_name, LENGTH(permission_name) - locate('-',REVERSE(permission_name)))"),'menu_id')->get();
        $permissionsactvie = $permissions->filter(function ($value, $key) {
            return $value->menu->menu_active == true;
        });
        $permission = array();
        foreach ($permissionsactvie as $row) {
            $permission[$row->menu->menu_parent][$row->menu_id]['name'] = $row->name;
            $permission[$row->menu->menu_parent][$row->menu_id]['menuid'] = $row->menu->id;
            $permission[$row->menu->menu_parent][$row->menu_id]['menuname'] = $row->menu->menu_name;
        }
        $data['pms'] = $permission;
        // dd($permission);
        // $menuchild = $permi->filter(function ($value, $key) {
        //     return $value->menu->menu_parent != 0;
        // });
        // dd($menuparent->all());
        // $data['pms'] = $menuchild->all();
        // $data['pms'] = Permission::select(\DB::raw("LEFT(permission_name,LENGTH(permission_name) - locate('-',REVERSE(permission_name))) as name"))->groupBy(\DB::raw("LEFT(permission_name, LENGTH(permission_name) - locate('-',REVERSE(permission_name)))"))->get();

        foreach ($data['role']->permissions as $permission) {
            $data['rps'][$permission->pivot->permission_id] = $permission->pivot->permission_id;
        }

        $modules = Permission::all();
        foreach ($modules as $module) {
            $rpos = strrpos($module->permission_name, '-');
            $name = substr($module->permission_name, 0, $rpos);
            // Module Action Id
            $data['mais'][$name][substr($module->permission_name, $rpos + 1)] = $module->id;
            // Module Action Name
            $data['mans'][substr($module->permission_name, $rpos + 1)] = substr($module->permission_name, $rpos + 1);
        }

        if (\Request::ajax()) {
            $view = view('backend.roles.edit')->with($data)->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.roles.edit')->with($data)->render();
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->role_name = $request->role_name;
        $role->role_description = $request->role_description;
        $role->save();

        $status = $role->permissions()->sync($request->permissionrole);
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
            $status = Role::destroy($ids);
        } else {
            $status = Role::findOrFail($ids)->delete();
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
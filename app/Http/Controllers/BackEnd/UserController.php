<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Market;
use Hash;

class UserController extends Controller
{
    public function __construct(){}

    public function index()
    {
        $users = User::UserRole()->get();
        if (\Request::ajax()) {
            $view = view('backend.users.index', compact('users'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.users.index', compact('users'))->render();
    }

    public function create()
    {
        $data['arrRoles'] = Role::pluck('role_name', 'id');
        if (\Request::ajax()) {
            $view = view('backend.users.create',compact('data'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.users.create',compact('data'))->render();
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = \Str::random(10) . '@gmail.com';
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->is_active = $request->is_active;
        $status = $user->save();
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
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $data['arrRoles'] = Role::pluck('role_name', 'id');
        if (\Request::ajax()) {
            $view = view('backend.users.edit', compact('user','data'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.users.edit', compact('user','data'))->render();
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->is_active = $request->is_active;
        $status = $user->save();
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
            $status = User::destroy($ids);
        } else {
            $status = User::findOrFail($ids)->delete();
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

    public function resetPass($id)
    {
        $user = User::findOrfail($id);
        if (\Request::ajax()) {
            $view = view('backend.users.resetpass', compact('user'))->renderSections();
            return response()->json([
                'content' => $view['content'],
                'css' => $view['css'],
                'js' => $view['js'],
            ]);
        }
        return view('backend.users.resetpass', compact('user'))->render();
    }

    public function updateResetPass(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill([
            'password' => Hash::make($request->newpassword),
        ]);
        $status = $user->save();
        if ($status) {
            $data['status'] = true;
            $data['message'] = "Password berhasil diganti!!!";
        } else {
            $data['status'] = false;
            $data['message'] = "Password gagal diganti!!!";
        }
        return response()->json(['code' => 200,'data' => $data], 200);
    }

    public function changePass()
    {
        return view('backend.users.m-changepass')->render();
    }

    public function updateChangePass(Request $request)
    {
        $user = User::findOrFail(\Auth::user()->id);
        if (Hash::check($request->oldpassword, \Auth::user()->password)) {
            $user->fill([
                'password' => Hash::make($request->newpassword),
            ]);
            $status = $user->save();
            if ($status) {
                $data['status'] = true;
                $data['message'] = "Password berhasil diganti!!!";
            } else {
                $data['status'] = false;
                $data['message'] = "Password gagal diganti!!!";
            }
            return response()->json(['code' => 200,'data' => $data], 200);
        } else {
            $data['status'] = false;
            $data['message'] = "Password lama salah!!!";
            return response()->json(['code' => 200,'data' => $data], 200);
        }
    }
}

<?php
namespace App\Libraries;

use App\Role;
use Auth;
use Illuminate\Http\Request;

class GPermissionLibrary
{

    /**
     * IoC
     * @var Illuminate\Foundation\Application
     */
    protected $app;

    static function uri()
    {
        return (\Request::route()->getPrefix()!=null)?\Request::segment(2):\Request::segment(1);
    }

    public static function hasPermission($permission)
    {
        $roles = Role::findOrFail(Auth::user()->role_id);
        foreach ($roles->permissions as $pr) {
            $data['roles'][$pr->id] = $pr->permission_name;
        }
        $result = @array_filter($data['roles'], function ($elem) use ($permission) {
            if (stripos($elem, $permission) !== false) {
                return true;
            }
            return false;
        });
        if ($result) {
            return true;
        } else {
            return false;
        }
        // return true;
    }

    public static function isPageActive()
    {
        $uri = self::uri();
        if (!GPermissionLibrary::permissionActive($uri)) {
            return abort(404);
        }
    }

    public static function permissionAdd()
    {
        $uri = self::uri();
        $permission = $uri . "-create";
        $check = GPermissionLibrary::hasPermission($permission);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function permissionEdit()
    {
        $uri = self::uri();
        $permission = $uri . "-edit";
        $check = GPermissionLibrary::hasPermission($permission);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function permissionDelete()
    {
        $uri = self::uri();
        $permission = $uri . "-delete";
        $check = GPermissionLibrary::hasPermission($permission);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function permissionPrint()
    {
        $uri = self::uri();
        $permission = $uri . "-print";
        $check = GPermissionLibrary::hasPermission($permission);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function permissionActive($uri)
    {
        // $uri = \Request::segment(1);
        $permission = $uri . "-active";
        $check = GPermissionLibrary::hasPermission($permission);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function permissionApprove()
    {
        $uri = self::uri();
        $permission = $uri . "-approve";
        $check = GPermissionLibrary::hasPermission($permission);
        if ($check > 0) {
            return true;
        } else {
            return false;
        }
    }

}

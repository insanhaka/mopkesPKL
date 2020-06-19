<?php

namespace App\Helpers;

use App\Libraries\GPermissionLibrary;
use Illuminate\Http\Request;

/**
 * GHelper class
 */
class GHelper
{
    static function uri()
    {
        $prefix = str_replace('/','',\Request::route()->getPrefix());
        return ($prefix!=null)?$prefix.'/'.\Request::segment(2):\Request::segment(1);
    }

    public static function btnCreate($caption = 'Add Data', $ajax = true)
    {
        if (GPermissionLibrary::permissionAdd()) {
            if ($ajax == true) {
                return \Form::button('<i class="fas fa-plus"></i> '.$caption, ['class' => 'btn btn-primary', 'data-request' => 'push', 'href' => url(\Request::path() . '/create')]);
            } else {
                return \Form::button('<i class="fas fa-plus"></i> '.$caption, ['class' => 'btn btn-primary', 'onClick' => "window.location='" . url(\Request::path() . '/create') . "'"]);
            }
        }
    }

    public static function btnCancel($caption = 'Cancel', $ajax = true)
    {
        $uri = self::uri();
        
        if ($ajax == true) {
            return \Form::button('<i class="fas fa-times-circle"></i> '.$caption, ['class' => 'btn btn-default', 'data-request' => 'push', 'href' => url($uri)]);
        } else {
            return \Form::button('<i class="fas fa-times-circle"></i> '.$caption, ['class' => 'btn btn-default', 'onClick' => "window.location='" . url($uri) . "'"]);
        }

    }

    public static function btnSaveModal($caption = 'Simpan')
    {
        return \Form::button('<i class="fas fa-save"></i> '.$caption, ['type' => 'submit','class' => 'btn btn-success btn-save']);
    }

    public static function btnDismisModal($caption = 'Cancel')
    {
        return \Form::button('<i class="fas fa-chevron-circle-left"></i> '.$caption, ['class' => 'btn btn-default', 'data-dismiss' => 'modal']);

    }

    public static function btnDeleteModal($id, $size = 'btn-xs', $caption = 'Delete')
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionDelete()) {
            return '<a class="dropdown-item has-icon bg-danger text-white '.$size.' modal-btn-hapus" data-url='.url($uri).' data-id='.$id.' href="#" title="Delete"><i class="far fa-trash-alt"></i> '.$caption.'</a>';
            // return link_to('#', $caption, ['class' => 'btn btn-danger '.$size.' modal-btn-hapus', 'data-url' => url($uri), 'data-id' => $id]);
        }
    }

    public static function btnSave($caption = 'Simpan')
    {
        return \Form::button('<i class="fas fa-save"></i> '.$caption, ['type' => 'submit','class' => 'btn btn-success btn-save']);
    }

    public static function btnPrint($caption = 'Print', $ajax = true)
    {
        if (GPermissionLibrary::permissionPrint()) {
            $push = $ajax == true ? 'push' : '';
            return \Form::submit($caption, ['class' => 'dropdown-item', 'data-request' => $push]);
        }
    }
    public static function btnPrintAfterApproved($data,$caption = 'Print',$target='_BLANK')
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionPrint()) {
            if($data->is_approve == true){
                return '<a class="dropdown-item has-icon btn-print" href="'.url($uri).'/print/'.$data->id.'" title="Cetak" target='.$target.'><i class="fas fa-print"></i> Print</a>';
            }
        }
    }

    public static function btnDeleteAll($caption = 'Hapus Beberapa')
    {
        if (GPermissionLibrary::permissionDelete()) {
            return "<button class='btn btn-danger' style='display:none' id='deleteall' type='submit'><i class='fa fa-times'></i> " . $caption . "</button>";
        }
    }

    public static function btnDelete($id)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionDelete()) {
            return '<a class="dropdown-item has-icon bg-danger text-white btn-hapus" data-url='.url($uri).' data-id='.$id.' href="#" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
            // return link_to('#', 'Delete', ['class' => 'dropdown-item has-icon btn-hapus', 'data-url' => url()->full(), 'data-id' => $id]);
        }
    }

    public static function btnDeleteIfNotApproved($data)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionDelete()) {
            if($data->is_approve == false){
            return '<a class="dropdown-item has-icon bg-danger text-white btn-hapus" data-url='.url($uri).' data-id='.$data->id.' href="#" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
            // return link_to('#', 'Delete', ['class' => 'dropdown-item has-icon btn-hapus', 'data-url' => url()->full(), 'data-id' => $id]);
            }
        }
    }

    public static function btnApproveAndDisapprove($data)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionApprove()) {
            if($data->is_approve == true){
                return '<a class="dropdown-item has-icon btn-approve" data-url='.url($uri).' data-id='.$data->id.' href="#" title="Disapproved"><i class="fas fa-ban"></i> Disapproved</a>';
            }else{
                return '<a class="dropdown-item has-icon btn-approve" data-url='.url($uri).' data-id='.$data->id.' href="#" title="Approved"><i class="fas fa-check-double"></i> Approved</a>';
            }
            
        }
    }

    public static function btnActiveAndNotActiveWithReason($data,$route)
    {
        if (GPermissionLibrary::permissionEdit()) {
            if($data->is_active == true){
                return '<a class="dropdown-item has-icon modalTrigger" href="'.route($route,$data).'" title="Non Activate"><i class="fas fa-ban"></i> Non Activated</a>';
            }else{
                return '<a class="dropdown-item has-icon modalTrigger" href="'.route($route,$data).'" title="Activated"><i class="fas fa-check"></i> Activated</a>';
            }
            
        }
    }

    public static function btnNotActiveAndActiveWithReason($data,$route)
    {
        if (GPermissionLibrary::permissionEdit()) {
            if($data->is_notactive == false){
                return '<a class="dropdown-item has-icon modalTrigger" href="'.route($route,$data).'" title="Non Activated"><i class="fas fa-ban"></i> Non Activated</a>';
            }else{
                return '<a class="dropdown-item has-icon modalTrigger" href="'.route($route,$data).'" title="Activated"><i class="fas fa-check"></i> Activated</a>';
            }
            
        }
    }

    public static function btnApprove($id)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionApprove()) {
            return '<a class="dropdown-item has-icon btn-approve" data-url='.url($uri).' data-id='.$id.' href="#" title="Approve"><i class="fas fa-check"></i> Approve</a>';
        }
    }

    public static function btnDisApprove($id)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionApprove()) {
            return '<a class="dropdown-item has-icon btn-approve" data-url='.url($uri).' data-id='.$id.' href="#" title="Disapprove"><i class="fas fa-ban"></i> Disapprove</a>';
        }
    }

    public static function cbDelete($id)
    {
        if (GPermissionLibrary::permissionDelete()) {
            return "<label><input type='checkbox' name='id[]' class='checkme' value='" . $id . "'><span class='text'></span></label>";
        }
    }

    public static function cbDeleteIfNotApproved($data)
    {
        if (GPermissionLibrary::permissionDelete()) {
            if($data->is_approve == false){
                return "<label><input type='checkbox' name='id[]' class='checkme' value='" . $data->id . "'><span class='text'></span></label>";
            }
        }
    }

    public static function btnEdit($id, $ajax = true)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionEdit()) {
            $push = $ajax == true ? 'push' : '';
            return '<a class="dropdown-item has-icon" data-request='.$push.' href="'.url($uri) . '/' . $id . '/edit'.'" title="Edit"><i class="far fa-edit"></i> Edit</a>';
        }
    }
    public static function btnEditIfNotApproved($data, $ajax = true)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionEdit()) {
            if($data->is_approve == false){
                $push = $ajax == true ? 'push' : '';
                return '<a class="dropdown-item has-icon" data-request='.$push.' href="'.url($uri) . '/' . $data->id . '/edit'.'" title="Edit"><i class="far fa-edit"></i> Edit</a>';
            }
        }
    }

    public static function btnResetPass($id, $ajax = true)
    {
        $uri = self::uri();
        if (GPermissionLibrary::permissionEdit()) {
            $push = $ajax == true ? 'push' : '';
            return '<a class="dropdown-item has-icon" data-request='.$push.' href="'.url($uri) . '/' . $id . '/resetpass'.'" title="Reset Password"><i class="fas fa-unlock-alt"></i> RP</a>';
            // return link_to(\Request::path() . '/' . $id . '/resetpass', 'RP', ['class' => 'dropdown-item has-icon', 'data-request' => $push]);
        }
    }

    public static function btnModal($route, $arr_param, $caption = 'modal', $size = 'btn-md')
    {
        // return link_to(\Request::path() . '/' . $route . '/' . $id, $caption, ['class' => 'btn btn-warning btn-xs modalTrigger']);
        return link_to(route($route, $arr_param), $caption, ['class' => 'btn btn-default ' . $size . ' modalTrigger']);
    }

    public static function menu($uri, $ajax = true)
    {
        if (GPermissionLibrary::permissionActive($uri)) {
            $menu_name = ucwords(str_replace('-', ' ', $uri));
            $push = $ajax == true ? 'push' : '';
            return '<a data-request="' . $push . '" title="' . $menu_name . '" href="' . url($uri) . '">
                        <span class="menu-text">' . $menu_name . '</span>
                    </a>';
        }
    }

    public static function breadcrumb($menu){
        $prefix = str_replace('/','',\Request::route()->getPrefix());
        if($menu=='dashboard'){
            if($prefix!=null){
                $link = link_to($prefix.'/dashboard','<i class="fas fa-home"></i>');
            }else{
                $link = link_to('dashboard','dashboard');
            }
        }else if($menu=='menu'){
            if($prefix!=null){
                $link = link_to($prefix.'/'.\Request::segment(2),\Request::segment(2));
            }else{
                $link = link_to(\Request::segment(1),\Request::segment(1));
            }
        }else{
            $link = link_to('#');
        }
        return $link;
        
    }

    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}

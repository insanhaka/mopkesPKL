<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        $username = (isset(\Auth::user()->username))?\Auth::user()->username:'blumpack';
        static::creating(function ($model) use ($username) {
            $model->created_by = $username;
        });
        static::updating(function ($model) use ($username){
            $model->updated_by = $username;
        });
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'permissionrole', 'permission_id', 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo('App\Menu', 'menu_id', 'id');
    }
}
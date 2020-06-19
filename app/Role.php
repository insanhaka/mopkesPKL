<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        $username = (isset(\Auth::user()->username))?\Auth::user()->username:'blumpack';
        static::creating(function ($model) use ($username) {
            $model->created_by = $username;
        });
        static::updating(function ($model) use ($username) {
            $model->updated_by = $username;
        });
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'permissionrole', 'role_id', 'permission_id');
    }
}
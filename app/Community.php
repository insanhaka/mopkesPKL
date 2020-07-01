<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_by = \Auth::user()->username;
        });
        static::updating(function ($model) {
            $model->updated_by = \Auth::user()->username;
        });
    }

    public function business()
    {
        return $this->hasMany('App\Bussiness', 'community_id', 'id');
    }

    public function agreement()
    {
        return $this->hasMany('App\Agreement', 'community_id', 'id');
    }
}

<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
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

    public function seller()
    {
        return $this->hasMany('App\Seller', 'sector_id', 'id');
    }
}

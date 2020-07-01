<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
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

    public function community()
    {
        return $this->belongsTo('App\Community', 'community_id', 'id');
    }

    public function business()
    {
        return $this->hasMany('App\Business', 'nik_id', 'id');
    }
}

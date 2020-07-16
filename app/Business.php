<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';

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

    public function sector()
    {
        return $this->belongsTo('App\Sector', 'sector_id', 'id');
    }

    public function report()
    {
        return $this->hasMany('App\Report', 'nik_id', 'id');
    }

    public function community()
    {
        return $this->belongsTo('App\Community', 'community_id', 'id');
    }

    public function agreement()
    {
        return $this->belongsTo('App\Agreement', 'nik_id', 'id');
    }

    public function district_lapak()
    {
        return $this->belongsTo('App\District', 'lapak_kec', 'id');
    }

    public function village_lapak()
    {
        return $this->belongsTo('App\Village', 'lapak_desa', 'id');
    }
}

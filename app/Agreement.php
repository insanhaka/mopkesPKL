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

    public function report()
    {
        return $this->hasMany('App\Report', 'nik_id', 'id');
    }

    public function province_dom()
    {
        return $this->belongsTo('App\Province', 'domisili_prov', 'id');
    }

    public function regency_dom()
    {
        return $this->belongsTo('App\Regency', 'domisili_kab', 'id');
    }

    public function district_dom()
    {
        return $this->belongsTo('App\District', 'domisili_kec', 'id');
    }

    public function village_dom()
    {
        return $this->belongsTo('App\Village', 'domisili_desa', 'id');
    }

    public function province_ktp()
    {
        return $this->belongsTo('App\Province', 'ktp_prov', 'id');
    }

    public function regency_ktp()
    {
        return $this->belongsTo('App\Regency', 'ktp_kab', 'id');
    }

    public function district_ktp()
    {
        return $this->belongsTo('App\District', 'ktp_kec', 'id');
    }

    public function village_ktp()
    {
        return $this->belongsTo('App\Village', 'ktp_desa', 'id');
    }
}

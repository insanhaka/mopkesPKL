<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
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

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    public function district_dom()
    {
        return $this->belongsTo('App\District', 'domisili_kec', 'id');
    }

    public function district_ktp()
    {
        return $this->belongsTo('App\District', 'ktp_kec', 'id');
    }

    public function district_lapak()
    {
        return $this->belongsTo('App\District', 'lapak_kec', 'id');
    }

    public function village_dom()
    {
        return $this->belongsTo('App\Village', 'domisili_desa', 'id');
    }

    public function village_ktp()
    {
        return $this->belongsTo('App\Village', 'ktp_desa', 'id');
    }

    public function village_lapak()
    {
        return $this->belongsTo('App\Village', 'lapak_desa', 'id');
    }
}

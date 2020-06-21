<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    public function regency()
    {
        return $this->belongsTo('App\Regency', 'regency_id', 'id');
    }

    public function villages()
    {
        return $this->hasMany('App\Village', 'district_id', 'id');
    }

    public function seller_domkec()
    {
        return $this->hasMany('App\Seller', 'domisili_kec', 'id');
    }
    public function seller_ktpkec()
    {
        return $this->hasMany('App\Seller', 'ktp_kec', 'id');
    }
    public function seller_lapkec()
    {
        return $this->hasMany('App\Seller', 'lapak_kec', 'id');
    }
}

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
}

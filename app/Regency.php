<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo('App\Province', 'province_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany('App\District', 'regency_id', 'id');
    }
}

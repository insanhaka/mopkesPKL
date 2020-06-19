<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];
    public function regencies()
    {
        return $this->hasMany('App\Regency', 'province_id', 'id');
    }
}

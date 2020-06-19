<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo('App\District', 'district_id', 'id');
    }
}

<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_by = "BlackID";
        });
        static::updating(function ($model) {
            $model->updated_by = "BlackID";
        });
    }

    public function pengusaha()
    {
        return $this->belongsTo('App\Pengusaha', 'nik_id', 'id');
    }
}

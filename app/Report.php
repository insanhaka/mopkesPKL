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

    public function business()
    {
        return $this->belongsTo('App\Business', 'nik_id', 'id');
    }
}

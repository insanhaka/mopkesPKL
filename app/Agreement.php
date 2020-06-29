<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{

    // protected $table = "agreements";

    // protected $fillable = ['name','attachment', 'status'];

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

    public function kelompok()
    {
        return $this->belongsTo('App\Kelompok', 'kelompok_id', 'id');
    }

    public function seller()
    {
        return $this->hasMany('App\Seller', 'nik_id', 'id');
    }
}

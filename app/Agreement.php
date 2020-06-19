<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{

    protected $table = "agreements";

    protected $fillable = ['name','attachment'];

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
}

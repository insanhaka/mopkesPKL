<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];
    protected static function boot()
    {
        parent::boot();
        $username = (isset(\Auth::user()->username))?\Auth::user()->username:'blumpack';
        static::creating(function ($model) use ($username) {

            $model->created_by = $username;
        });
        static::updating(function ($model) use ($username){
            $model->updated_by = $username;
        });
    }

    public function permissions()
    {
        return $this->hasMany('App\Permission', 'id', 'menu_id');
    }
}

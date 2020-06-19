<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id','market_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        $username = (isset(\Auth::user()->username))?\Auth::user()->username:'blumpack';
        static::creating(function ($model) use ($username) {
            $model->created_by = $username;
        });
        static::updating(function ($model) use ($username) {
            $model->updated_by = $username;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function scopeUserRole($query)
    {
        if(\Auth::user()->role_id == 2){
            return $query->where('role_id','!=', 1);
        }
    }

    public static $rules = array(
        'username' => 'required',
        'name' => 'required',
        'role_id' => 'required',
    );

    public function role()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function market()
    {
        return $this->hasOne('App\Market', 'id', 'market_id');
    }
}

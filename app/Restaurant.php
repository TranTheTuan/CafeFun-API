<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function foods()
    {
        return $this->hasMany('App\Food');
    }

    public function tables()
    {
        return $this->hasMany('App\Table');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function address()
    {
        return $this->hasOne('App\Address');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}

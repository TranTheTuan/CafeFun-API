<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function table()
    {
        return $this->belongsTo('App\Table');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function foods()
    {
        return $this->belongsToMany('App\Food')->withPivot('number')->withTimestamps();
    }
}

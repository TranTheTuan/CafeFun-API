<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}

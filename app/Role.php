<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }
}

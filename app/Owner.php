<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    public function role()
    {
        return $this->hasOne('App\Role');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function property()
    {
        return $this->hasMany('App\Property');
    }
}

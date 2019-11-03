<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function manager()
    {
        return $this->hasMany('App\Manager');
    }

    public function tenant()
    {
        return $this->hasMany('App\Tenant');
    }

    public function owner()
    {
        return $this->hasOne('App\Owner');
    }
}

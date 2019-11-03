<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    public function role()
    {
        return $this->hasOne('App\Role');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function proerty()
    {
        return $this->belongsTo('App\Property');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }

    public function owner()
    {
        return $this->belongsTo('App\Owner');
    }

    public function manager()
    {
        return $this->belongsTo('App\Manager');
    }
    
}

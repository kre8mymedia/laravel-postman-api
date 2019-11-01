<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }

    public function manager()
    {
        return $this->belongsTo('App\Manager');
    }

}

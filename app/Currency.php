<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function profiles()
    {
        return $this->hasMany('App\Profile','default_currency_id','id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction','currency_id','id');
    }
}

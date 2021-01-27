<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repeat extends Model
{
    public function transactions()
    {
        return $this->hasMany("App\Transaction",'repeat_id','id');
    }
}

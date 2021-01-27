<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function profile()
    {
        return $this->belongsTo('App\Profile','profile_id');
    }

    public function logo()
    {
        return $this->belongsTo('App\Logo','logo_id');
    }

    public function transactions()
    {
        return $this->hasMany('App/Transaction','category_id','id');
    }
}

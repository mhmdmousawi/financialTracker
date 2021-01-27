<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function profile()
    {
        return $this->belongsTo('App\Profile','profile_id');
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency','currency_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function repeat()
    {
        return $this->belongsTo('App\Repeat','repeat_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    //
    protected $guarded = [];

    public function invoice(){
        return $this->hasMany('App\Invoice');
    }

}

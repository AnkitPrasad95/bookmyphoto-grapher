<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = "sliders";
    // public $timestamps = false;

    public function servicename(){
        return $this->hasOne('App\Models\Service','id','service_id')->select('id','name');
    }
}

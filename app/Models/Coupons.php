<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Coupons extends Model
{
    protected $table = "coupons";
    // public $timestamps = false;

    public function servicename(){
        return $this->hasOne('App\Models\Service','id','service_id')->select('id','name',DB::raw("CONCAT('".asset('storage/app/public/service')."/', services.image) AS image_url"));
    }
}

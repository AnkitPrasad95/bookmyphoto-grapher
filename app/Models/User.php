<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;



class User extends Model

{

    protected $table = 'users';

    // public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'mobile',
        'image',
        'google_id',
        'type',
        'otp',
        'address',
        'referral_code',
        'is_verified',
        'is_available',
    ];

    public function providertype(){

        return $this->hasOne('App\Models\ProviderType','id','provider_type')->select('id','name');

    }



    public function providername(){

        return $this->hasOne('App\Models\User','id','provider_id')->select('id','name');

    }



    public function city(){

        return $this->hasOne('App\Models\City','id','city_id')->select('id','name');

    }



    public function rattings(){

        return $this->hasMany('App\Models\Rattings','provider_id','id');

    }

    public function api_rattings(){

        return $this->hasMany('App\Models\Rattings','provider_id','id')->select('provider_id',DB::raw('ROUND(AVG(ratting),1) as avg_ratting'))->groupBy('provider_id');

    }

    

}


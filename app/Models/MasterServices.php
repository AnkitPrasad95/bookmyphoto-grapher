<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterServices extends Model
{
    protected $table = 'master_services';
    // public $timestamps = false;

    protected $fillable=['name','image'];
}
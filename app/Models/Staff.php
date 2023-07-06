<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DeviceInfo;
use App\Models\Restaurant;

class Staff extends Authenticatable
{
    use HasFactory;
    protected $guard = 'staff';

    public function getDeviceInfo(){
    	return $this->hasOne(DeviceInfo::class,'staff_id','id');
    }
    public function getRestorData(){
    	return $this->hasOne(Restaurant::class,'restor_id','id');
    }
}

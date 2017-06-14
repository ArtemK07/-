<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'user';
    public $timestamps = false;


    public function companies(){
        return $this->belongsTo('App\Company','company_id');
    }
    public function transferLogs(){
        return $this->hasMany('App\TrasnferLogs','user_id','id');
    }
}

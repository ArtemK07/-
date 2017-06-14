<?php
/**
 * Created by PhpStorm.
 * User: Yuriy.M
 * Date: 13.06.2017
 * Time: 16:23
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    public $timestamps = false;
    public function users(){
        return $this->hasMany('App\User','company_id','id');
    }
}
<?php namespace Modules\Openclass\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Member extends Model {

    protected $fillable = ["username","email","password"];

}
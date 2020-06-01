<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Conversion_history extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'conversion_history';
    protected $fillable = [
          'conversion_id','rate_new', 'rate_old', 'date_create'
    ];
    
    protected $hidden = [
       'date_update'
    ];
     
}

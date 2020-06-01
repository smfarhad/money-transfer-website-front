<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'conversion';
    protected $fillable = [
          'base_country_id', 'country_id', 'rate', 'date_create'
    ];
    
    protected $hidden = [
       'date_update'
    ];
     
}

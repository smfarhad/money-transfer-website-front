<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'country';
    protected $fillable = [
                           'name', 'currency' , 'country_code', 'iso','currency_conversion',
                           'isAvailable' , 'isBank' , 'isCash', 'isMobile', 
                           'date_create'];

    protected $hidden = ['date_update'];
     
}

  
<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate_history extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'conversion_rate_history';
    protected $fillable = [
          'new_rate', 'last_rate','new_fee', 'last_fee', 'admin_id', 'note', 'date_create', 'date_update'
    ];
    
    protected $hidden = [
       
    ];
     
}

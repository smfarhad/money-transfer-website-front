<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'conversion_rate';
    protected $fillable = ['country', 'min_range','max_range', 'rate', 'fee'];
    
    protected $hidden = ['date_create','date_update'];
     
}

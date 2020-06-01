<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'recipient';
    protected $fillable = [
          'id', 'first_name', 'last_name', 'user_id', 'date_create'
    ];
    
    protected $hidden = [
       
    ];
     
}

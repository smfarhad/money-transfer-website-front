<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'user_info';
    protected $fillable = [
        'first_name', 'last_name', 'mobile', 'personnumber', 'city', 'date_create' ,'address_1', 
        'address_2', 'suburb', 'postcode', 'city', 'email'
    ];
    
    protected $hidden = [
       
    ];
     
}

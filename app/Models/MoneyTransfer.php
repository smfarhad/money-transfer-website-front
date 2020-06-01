<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class MoneyTransfer extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'money_transfer';
    protected $fillable = ['recipient_id', 'api_type','source_amount', 'fees', 'source_total', 'destination_country',
                           'convertion_rate', 'destination_amount', 'note', 'date_execution', 'date_create', 
                           'date_update','status'];
    
    protected $hidden = [
         'date_update'
    ];
     
}

<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TransferComplete extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'transfer_complete';
    protected $fillable = [
        'transfer_id','bakaal_TransNo', 'api_type','recipient_id', 
        'source_amount', 'fees','source_amount_usd', 'fees_usd', 'receive_type',
        'source_total', 'destination_country',
        'convertion_rate', 'destination_amount', 
        'admin_id','note', 'date_execution', 'date_create','status','sms_send',
        'date_update'];

    protected $hidden = [
        'date_update'
    ];
     
}

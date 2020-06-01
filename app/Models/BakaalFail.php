<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class BakaalFail extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'bakaal_fail';
    protected $fillable = ['transfer_id', 'trans_no','api_type', 'code', 'description', 'note', 'date_create', 'date_update'];

    protected $hidden = [ 'date_update' ];
     
}

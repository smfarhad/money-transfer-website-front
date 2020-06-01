<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class AgentList extends Model
{
    //table name
    public $timestamps = false;
    protected $table = 'bakaal_agent_list';
    protected $fillable = ['AgentCode', 'AgentLocation' , 'AgentName', 'CountryCode', 
                           'CountryName' , 'MainAgentCode' , 'note', 'date_update'];

    protected $hidden = ['date_update'];
     
}

  
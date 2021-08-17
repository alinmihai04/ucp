<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    public static $reason_text = array(
    	1 => 'DM',
    	2 => 'Faction complaint',
    	3 => 'Offensive language',
    	4 => 'Scam',
    	5 => 'Other',
    	6 => 'Admin/helper abuse',
    	7 => 'Leader mistake'
    );
}

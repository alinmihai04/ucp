<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class House extends Model
{
    public static function getHouseData($houseid)
    {
    	if(Cache::has('housedata'.$houseid.''))
    	{
    		$value = Cache::get('housedata'.$houseid.'');
    	}
    	else
    	{
    		$value = self::where('id', '=', $houseid)->limit(1)->get();

    		Cache::add('housedata'.$houseid.'', $value, 5);
    	}
    	return $value;
    }
}

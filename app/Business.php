<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Business extends Model
{
    public static function getBizzData($bizid)
    {
    	if(Cache::has('bizdata'.$bizid.''))
    	{
    		$value = Cache::get('bizdata'.$bizid.'');
    	}
    	else
    	{
    		$value = self::where('id', '=', $bizid)->limit(1)->get();
    		Cache::add('bizdata'.$bizid.'', $value, 5);
    	}
    	return $value;
    }
}

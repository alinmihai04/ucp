<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Clan extends Model
{
    public static function getClanName($clanid)
    {
    	if(Cache::has('clandata'.$clanid))
    	{
    		$value = Cache::get('clandata'.$clanid)->first();

            if(!is_object($value))
            {
                return 'N/A';
            }
    	}

    	if(Cache::has('clan_name'.$clanid))
    	{
    		$value = Cache::get('clan_name'.$clanid);
    	}
    	else
    	{
    		$value = DB::table('clans')->where('id', '=', $clanid)->value('clan_name');
    		Cache::add('clan_name'.$clanid, $value, 15);	
    	}

        if(!is_string($value))
        {
            return 'N/A';
        }  

    	return $value;
    }

    public static function getClanData($clanid)
    {
    	$value = Cache::remember('clandata'.$clanid, 15, function() use ($clanid) {
    		return DB::table('clans')->where('id', '=', $clanid)->get();
    	});

    	return $value;
    }
}

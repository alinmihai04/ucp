<?php

// NOT A PROPER MODEL, FUNCTION FOR HEADER

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Header extends Model
{
    public static function countHeaderFactions()
    {
    	return Cache::get('header_factions');
    }

    public static function countHeaderStaff()
    {
    	if(Cache::has('header_staff'))
    	{
    		$value = Cache::get('header_staff');
    	}
    	else 
    	{
    		$online = DB::table('users')->whereRaw("(user_helper > 0 OR user_admin > 0) AND user_status>0")->count();
    		$total = DB::table('users')->whereRaw("user_helper > 0 OR user_admin > 0")->count();

    		$value = $online."/".$total;
    		Cache::add('header_staff', $value, 30);
    	}
    	return $value;
    }

    public static function countHeaderComplaints()
    {
    	$value = Cache::remember('header_complaints', 30, function() {
    		return DB::table('panel_topics')->whereRaw("type=1 AND status=0")->count();
    	});
    	
    	return $value;
    }

    public static function headerLoadEmails($user)
    {
        if(Cache::has('useremails'.$user.''))
        {
            $value = Cache::get('useremails'.$user.'');
        }
        else 
        {
            $value = DB::table('emails')->where('playerid', '=', $user)->where('seen', '=', 0)->count();
            Cache::add('useremails'.$user.'', $value, 1);
        }

        return $value;
    }
    public static function countHeaderBids()
    {
        $value = Cache::remember('header_bids', 30, function() {
            return DB::table('businesses')->where('biz_ownerid', '=', 0)->count() + DB::table('houses')->where('house_ownerid', '=', 0)->count();
        });
        return $value;
    }
}

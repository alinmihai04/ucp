<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cache;

class StatsController extends Controller
{
    public function top()
    {
    	$data = Cache::remember('stats_top', 120, function() {
    		return DB::table('users')->select('id', 'name', 'user_level', 'user_hours', 'user_rp', 'user_status', 'user_admin', 'user_helper', 'user_grouprank')->limit(500)->get();
    	});
    	return view('stats.top')->with('data', $data);
    }
    public function houses()
    {
    	$data = Cache::remember('stats_houses', 120, function() {
    		return DB::table('houses')->join('users', 'users.id', '=', 'houses.house_ownerid')->select('houses.*', 'users.name')->get();
    	});

    	return view('stats.houses')->with('data', $data);
    }
    public function businesses()
    {
    	$data = Cache::remember('stats_businesses', 120, function() {
    		return DB::table('businesses')->join('users', 'users.id', '=', 'businesses.biz_ownerid')->select('businesses.*', 'users.name')->get();
    	});

    	return view('stats.biz')->with('data', $data);
    }
}

<?php

namespace App;

use App\Header;
use App\Http\Controllers\ServerController;
use Cache;
use DB;

class Task
{
    public function bids()
    {
    	return 1;
    }
    public function header_factions()
    {
    	Cache::remember('header_factions', 5, function() {
            return DB::table('groups')->where('group_application', '=', 1)->count();
        });
    }
}

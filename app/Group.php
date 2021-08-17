<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cache;

class Group extends Model
{
    public static $groupTypeName = array(
        'Police', 'Hitman', 'Taxi', 'News Reporters', 'School Instructors', 'Gang', 'Paramedic'
    );

	public static function loadAllGroups()
	{
		return self::all();
	}

    public static function getGroupData($groupid)
    {
    	if(Cache::has('groupdata'.$groupid))
    	{
    		$value = Cache::get('groupdata'.$groupid);
    	}
    	else
    	{
    		$value = self::where('group_id', '=', $groupid)->get()->first();

    		Cache::add('groupdata'.$groupid.'', $value, 300);
    	}
    	return $value;
    }

    public static function getGroupName($groupid)
    {
        $value = self::getGroupData($groupid);

        if(!is_object($value))
        {
            session()->flash('error', 'Invalid group data.');
            return redirect('/');
        }

    	return $value->group_name;
    }
    public static function getGroupType($group)
    {
        $value = self::getGroupData($group);

        return $value->group_type;
    }
    public static function getUserGroupFW($user)
    {
        if(Cache::has('usergroup'.$user.''))
        {
            return Cache::get('usergroup'.$user.'')->first()->fw;
        }
        else
        {
            $value = DB::table('f_members')->where('user', '=', $user)->limit(1)->get();

            if($value->isEmpty())
            {
                return 0;
            }

            Cache::add('usergroup'.$user.'', $value, 5);
        }
        return $value->first()->fw;
    }
}

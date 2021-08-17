<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cache;
use DB;

class Job extends Model
{
    public static function getJobName($job)
    {
    	if(Cache::has('jobname'.$job.''))
    	{
    		return Cache::get('jobname'.$job.'');
    	}
    	else
    	{
    		$value = self::where('id', '=', $job)->value('job_name');

            if(is_null($value))
            {
                return 'Unemployed';
            }

    		Cache::add('jobname'.$job.'', $value, 60);
    	}
    	return $value;
    }
}

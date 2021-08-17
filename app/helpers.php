<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (! function_exists('me')) {
	function me()
	{
		if(Auth::check())
		{
			$data = Cache::remember('userdata' . Auth::id(), 3, function() {
				return DB::table('users')->where('id', '=', Auth::id())->limit(1)->get();
			});

			return $data->first();
		}
		else
		{
			return null;
		}
	}
}

if (! function_exists('important_log')) {
	function important_log($user, $alt_user, $text, $type)
	{
		DB::table('player_importantlogs')->insert([['player' => $user, 'alt_player' => $alt_user, 'text' => $text, 'type' => $type]]);
	}
}

if (! function_exists('staff_log')) {
	function staff_log($text)
	{
		DB::table('staff_logs')->insert([['text' => $text]]);
	}
}
if (! function_exists('punish_log')) {
	function punish_log($user, $text)
	{
		DB::table('punish_logs')->insert([['playerid' => $user, 'text' => $text]]);
	}
}
if (! function_exists('admin_log')) {
	function admin_log($user, $alt_user, $text)
	{
		DB::table('admin_logs')->insert([['user_id' => $user, 'alt_user' => $alt_user, 'text' => $text]]);
	}
}
if (! function_exists('user_log')) {
	function user_log($user, $alt_user, $text, $type)
	{
		DB::table('player_logs')->insert([['user_id' => $user, 'alt_user' => $alt_user, 'text' => $text, 'type' => $type]]);
	}
}
if (! function_exists('email')) {
	function email($user, $text, $link)
	{
		DB::table('emails')->insert([['playerid' => $user, 'message' => $text, 'link' => $link]]);
	}
}

function secondsformat($sec)
{
	if($sec >= 7200)
	{
		return intval($sec/3600) . " hours";
	}
	else if($sec>=3600)
	{
		$rest = $sec%3600;
		$hours = $sec/3600;
		$hours2 = intval($hours);
		if($rest >= 60)
		{
			$rest2 = $rest%60;
			$minutes = $rest/60;
			$minutes2 = intval($minutes);
			if($rest2 > 0)
			{
				$msg = "".$hours2." hours, ".$minutes2." minutes, ".$rest2." seconds";
				return $msg;
			}
			else
			{
				$msg = "".$hours2." hours, ".$minutes2." minutes";
				return $msg;					
			}
		}
		else
		{
			$msg = "".$hours2." hours";
			return $msg;					
		}	
	}
	else if($sec>=60 && $sec<3600)
	{
		$rest = $sec%60;
		$minutes = $sec/60;
		$minutes2 = intval($minutes);
		if($rest > 0)
		{
			$msg = "".$minutes2." minutes, ".$rest." seconds";
			return $msg;
		}
		else
		{
			$msg = "".$minutes2." minutes";
			return $msg;					
		}
	}
	else
	{
		$msg = "".$sec." seconds";
		return $msg;			
	}
}

function activateUrl($str) {
    $find = array('`((?:https?|ftp)://\S+[[:alnum:]]/?)`si', '`((?<!//)(www\.\S+[[:alnum:]]/?))`si');
    $replace = array('<a href="$1" target="_blank">$1</a>', '<a href="http://$1" target="_blank">$1</a>');
    return preg_replace($find,$replace,$str);	
}

function findProfile($text)
{
	$pos = strpos($text, "[user:");

	if($pos)
	{
		$pos2 = strpos($text, ":");
		$pos3 = strpos($text, "]");

		$id = substr($text, $pos2+1, $pos3-$pos2-1);

		$first;

		sscanf($text, " %s[user:" . $id . "]", $first);
		
		$text = str_replace($first, "<a href='" . url('/profile/' . $id) . "'>" . $first . "</a>", $text);

		return $text;
	}
	return $text;
}

function makeLinks($text)
{
	$text = activateUrl($text);
	return $text;
}

function transdate($timestamp) 
{
		if ($timestamp >= strtotime("today"))
    	echo "today, " . date('H:i', $timestamp);
	 	else if ($timestamp >= strtotime("yesterday"))
    	echo "yesterday, " . date('H:i', $timestamp);
    else
    	echo date('d.m.Y, H:i', $timestamp);
}
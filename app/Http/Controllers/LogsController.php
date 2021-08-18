<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;


class LogsController extends Controller
{
    public static function player($user)
    {
    	$data = DB::table('player_logs')->where('user_id', '=', $user)->orWhere('alt_user', '=', $user)->orderBy('entry', 'desc')->paginate(50);

    	if($data->isEmpty())
    	{
    		session()->flash('error', 'No logs available for this player.');
    		return redirect('/profile/'.User::getName($user));
    	}

    	return view('logs.logs', ['data' => $data, 'username' => User::getName($user), 'user' => $user]);
    }
    public static function important($user)
    {
        $data = DB::table('player_importantlogs')->where('player', '=', $user)->orWhere('alt_player', '=', $user)->orderBy('entry', 'desc')->paginate(50);

        if($data->isEmpty())
        {
            session()->flash('error', 'No logs available for this player.');
            return redirect('/profile/'.User::getName($user));
        }

        return view('logs.logs', ['data' => $data, 'username' => User::getName($user), 'user' => $user]);
    }
    public static function chat($user)
    {
        if(Auth::check() && me()->user_admin < 5)
        {
            session()->flash('error', 'Unauthorized access.');
            return redirect('/');
        }

        $data = DB::table('chat_logs')->where('user_id', '=', $user)->orderBy('entry_id', 'desc')->paginate(50);

        if($data->isEmpty())
        {
            session()->flash('error', 'No logs available for this player.');
            return redirect('/profile/'.User::getName($user));
        }

        return view('logs.logs', ['data' => $data, 'username' => User::getName($user), 'user' => $user]);
    }
    public static function vehicle($vehicle)
    {
        $data = DB::table('vehicle_logs')->where('vehicleid', '=', $vehicle)->orderBy('entry', 'desc')->paginate(50);

        if($data->isEmpty())
        {
            session()->flash('error', 'No logs available for this vehicle.');
            return redirect('/');
        }

        return view('logs.vehicle', ['data' => $data, 'name' => 'vehicle id: '.$vehicle, 'id' => $vehicle]);
    }
    public static function clan($clan)
    {
        $data = DB::table('clan_logs')->where('clanid', '=', $clan)->orderBy('id', 'desc')->paginate(50);

        if($data->isEmpty())
        {
            session()->flash('error', 'No logs available for this clan.');
            return redirect('/');
        }

        return view('logs.clan', ['data' => $data, 'clan' => $clan]);
    }
    public function raport()
    {
        $data = DB::table('raport_logs')->orderBy('id', 'desc')->paginate(50);

        return view('logs.raport')->with('data', $data);
    }
}

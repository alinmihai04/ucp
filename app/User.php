<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;
use DB;
use App\Http\Controllers\ServerController;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;

    public static function getSkin($user)
    {
        if(Cache::has("userskin".$user.""))
        {
            $value = Cache::get("userskin".$user."");
        }
        else
        {
            $value = self::where('id', '=', $user)->limit(1)->value('user_skin');
            Cache::add("userskin".$user."", $value, 5);
        }
        return $value;
    }
    public static function getName($user)
    {
        if(Cache::has('userdata'.$user))
        {
            return Cache::get('userdata'.$user)->first()->name;
        }
        else if(Cache::has("username".$user))
        {
            $value = Cache::get("username".$user);
        }
        else
        {
            $value = self::where('id', '=', $user)->limit(1)->value('name');

            if($value == null)
            {
                return 'N/A';
            }

            Cache::add("username".$user, $value, 5);
        }
        return $value;
    }


    public static function setInternalId($name, $id)
    {
        Cache::forever("internal".$name."", $id);
        return 1;
    }
    public static function getInternalId($name)
    {
        if(Cache::has("internal".$name.""))
        {
            $value = Cache::get("internal".$name."");
        }
        else
        {
            $value = self::where('name', '=', $name)->limit(1)->value('id');

            if(!$value)
            {
                return -1;
            }

            Cache::add("internal".$name."", $value, 5);
        }
        return $value;
    }
    public static function fetchUserData($user)
    {
        if(Cache::has("userdata" . $user))
        {
            $value = Cache::get("userdata" . $user);
        }
        else
        {
            $value = self::where('id', '=', $user)->limit(1)->get();

            if($value->isEmpty())
            {
                return null;
            }

            Cache::add("userdata" . $user, $value, 3);
        }
        return $value->first();
    }
    public static function getMoney($user)
    {
        $data = self::fetchUserData($user);

        return $data->user_money + $data->user_bankmoney;
    }
    public static function getPlayerFactionLogs($user)
    {
        if(Cache::has("userfh".$user))
        {
            $value = Cache::get("userfh".$user);
        }
        else
        {
            $value = DB::table('faction_logs')->where('player', '=', $user)->orderBy('id', 'desc')->get();
            Cache::add("userfh".$user, $value, 3);
        }
        return $value;
    }

    public static function getPlayerLastPunish($user)
    {
        if(Cache::has('lpdata'.$user))
        {
            $value = Cache::get('lpdata'.$user);
        }
        else
        {
            $value = DB::table('punish_logs')->where('playerid', '=', $user)->orderBy('id', 'desc')->get();
            Cache::add('lpdata'.$user, $value, 1);
        }
        return $value;
    }
    public static function getPlayerLastTransactions($user)
    {
        $value = DB::table('player_logs')->whereRaw("(user_id='". $user . "' OR alt_user='" . $user . "') AND type='transaction'")->orderBy('entry', 'desc')->limit(20)->get();
        return $value;
    }

    public static function getPlayerBanStatus($user)
    {
        $value = Cache::remember('banstats'.$user, 5, function() use ($user) {
            return DB::table('bans')
                ->where('ban_playername', '=', self::getName($user))
                ->where(function($query) {
                    $query->where('ban_expiretimestamp', '>=', time())
                          ->orWhere('ban_permanent', '=', 1);
            })->get();
        });
        return $value->first();
    }
    public static function last7($user)
    {
        $value = Cache::remember('last7' . $user, 60, function() use ($user) {
            return DB::table('player_activity')->where('time', '>=', 'DATE_SUB(CURDATE(), INTERVAL 7 DAY)')->where('player', '=', $user)->sum('seconds');
        });

        return secondsformat($value);
    }
    public static function last_nre($user)
    {
        $value = Cache::remember('last_nre' . $user, 60, function() use ($user) {
            return DB::table('helpers_activity')->where('date', '>=', 'DATE_SUB(CURDATE(), INTERVAL 7 DAY)')->where('player', '=', $user)->sum('ncount');
        });

        Cache::add('last_nre_time' . $user, date('Y-m-d H:i'), 60);

        return $value;
    }
    public static function last_nre_time($user)
    {
        return Cache::get('last_nre_time' . $user);
    }
    public static function uninvitePlayer($user, $by, $reason, $fp)
    {
        $name = self::where('id', '=', $user)->select('name')->get()->first();
        $f_data = DB::table('f_members')->where('user', '=', $user)->selectRaw('rank, faction, TIMESTAMPDIFF(DAY, f_members.joined, NOW()) AS days')->get()->first();

        $text = $name . " was uninvited by " . $by . " from faction " . Group::getGroupName($f_data->faction) . " (rank " . $f_data->rank . ") after " . $f_data->days . " days, " . ($fp == 0 ? "without FP" : "with " . $fp . " FP") . ". Reason: " . $reason;

        DB::table('f_members')->where('user', '=', $user)->delete();
        DB::table('f_stats')->where('user_id', '=', $user)->delete();
        DB::table('faction_warns')->where('user', '=', $user)->delete();
        DB::table('users')->where('id', '=', $user)->update(['user_group' => 0, 'user_grouprank' => 0, 'user_skin' => 250, 'user_fw' => 0, 'user_fp' => $fp]);

        if($f_data->rank == 7)
        {
            DB::table('groups')->where('group_id', '=', $f_data->faction)->update(['group_leader' => 'None']);
        }

        DB::table('faction_logs')->insert([['player' => $user, 'text' => $text]]);
        DB::table('flogs')->insert([['faction' => $f_data->faction, 'text' => $text]]);

        ServerController::sendPanelAction($user, 11, $fp, $f_data->faction, $text);

        $email = "Ai fost demis din factiunea din care faceai parte de catre " . $by . " dupa " . $f_data->days  . " zile. Motiv: " . $reason;

        email($user, $email, '#');
    }
    public static function getFriends($user)
    {
        $friends = Cache::remember('userfriends' . $user, 5, function() use ($user) {
            return DB::table('player_friends')->where('friendid', '=', $user)->get();
        });

        return $friends;
    }
}

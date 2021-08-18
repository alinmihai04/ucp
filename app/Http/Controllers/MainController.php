<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use DB;
use Auth;
use App\Group;
use App\User;

class MainController extends Controller
{

    public function home(Request $request)
    {
    	$onlineusers = Cache::remember('onlineusers', 10, function() {
    		return DB::table('users')->where('user_status', '>', '0')->count();
    	});
    	$onlinetoday = Cache::remember('onlinetoday', 30, function() {
    		return DB::table('users')->whereRaw('last_login >= CURDATE()')->count();
    	});
    	$onlineweek = Cache::remember('onlineweek', 30, function() {
    		return DB::table('users')->whereRaw('last_login >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')->count();
    	});
    	$registered = Cache::remember('registered', 60, function() {
    		return DB::table('users')->count();
    	});
    	$cars = Cache::remember('cars', 60, function() {
    		return DB::table('player_vehicles')->count();
    	});
    	$houses = Cache::remember('houses', 300, function() {
    		return DB::table('houses')->count();
    	});
    	$biz = Cache::remember('biz', 300, function() {
    		return DB::table('businesses')->count();
    	});
    	$flog = Cache::remember('flog', 3, function() {
    		return DB::table('faction_logs')->join('users', 'users.id', '=', 'faction_logs.player')->select('faction_logs.*', 'users.name', 'users.user_skin')->orderBy('id', 'desc')->limit(10)->get();
    	});
        $slog = Cache::remember('slog', 3, function() {
            return DB::table('staff_logs')->orderBy('id', 'desc')->limit(10)->get();
        });

        $me = me();
        $auth = Auth::check();

        $complaintsdata = null;
        $banstats = null;

        if($auth)
        {
            $complaintsdata = Cache::remember('complaintsopened' . $me->id, 5, function() use ($me) {
                return DB::table('panel_topics')->where('user_id', '=', $me->id)->where('status', '=', 0)->select('id', 'reason', 'time')->get();
            });
            $banstats = User::getPlayerBanStatus($me->id);

            if($complaintsdata->isEmpty())
            {
                $complaintsdata = null;
            }
            if(!is_object($banstats))
            {
                $banstats = null;
            }
        }


        if($auth && $me->user_admin > 0)
        {
            $nlgroups = Cache::remember('nlgroups', 5, function() {
                return DB::table('groups')->where('group_leader', '=', 'none')->select('group_name')->get();
            });

            $complaints = Cache::remember('complaintstats', 5, function() {
                return DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 0)->orWhere('status', '=', 4)->orWhere('status', '=', 2)->get();
            });

            return view('main.home', ['onlineusers' => $onlineusers, 'onlinetoday' => $onlinetoday, 'onlineweek' => $onlineweek, 'registered' => $registered, 'cars' => $cars, 'houses' => $houses, 'biz' => $biz, 'flog' => $flog, 'slog' => $slog, 'me' => $me, 'auth' => $auth, 'nlgroups' => $nlgroups, 'complaints' => $complaints, 'complaintsdata' => $complaintsdata]);
        }

    	return view('main.home', ['onlineusers' => $onlineusers, 'onlinetoday' => $onlinetoday, 'onlineweek' => $onlineweek, 'registered' => $registered, 'cars' => $cars, 'houses' => $houses, 'biz' => $biz, 'flog' => $flog, 'slog' => $slog, 'me' => $me, 'auth' => $auth, 'complaintsdata' => $complaintsdata, 'banstats' => $banstats]);
    }
    public function online()
    {
        $groups = Cache::remember('onlinepage_groups', 60, function() {
            return DB::table('groups')->select('group_name', 'group_id')->get();
        });

        $users = Cache::remember('onlinepage', 10, function() {
            return DB::table('users')->select('name', 'user_skin', 'user_level', 'user_group', 'user_hours', 'user_rp')->where('user_status', '>', '0')->get();
        });

        return view('main.online', ['groups' => $groups, 'usersdata' => $users]);
    }
    public function staff()
    {
        $data = Cache::remember('staffpage', 15, function() {
            return DB::table('users')->where('user_admin', '>', 0)->orWhere('user_helper', '>', 0)->orWhere('user_grouprank', '=', 7)->select('id', 'name', 'user_status', 'last_login', 'user_admfunc', 'user_beta', 'user_support', 'user_helper', 'user_admin', 'user_group', 'user_grouprank', 'user_laststaffchange')->get();
        });
        $groups = Cache::remember('staffpage_groups', 60, function() {
            return DB::table('groups')->where('group_leader', '!=', 'None')->get();
        });
        $complaints_7d = Cache::remember('staffpage_complaints_7d', 60, function() {
            return DB::table('panel_topics')->whereRaw('time >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)')->where('type', '=', 1)->count();
        });
        $complaints_24h = Cache::remember('staffpage_complaints_24h', 60, function() {
            return DB::table('panel_topics')->whereRaw('time >= CURDATE()')->where('type', '=', 1)->count();
        });
        $newbie = Cache::remember('staffpage_newbie', 60, function() {
            return DB::table('helpers_activity')->where('date', '>=', 'DATE_SUB(CURDATE(), INTERVAL 7 DAY)')->count();
        });

        foreach($data as $d)
        {
            $d->last7 = User::last7($d->id);
            $d->staffchange = floor((time() - $d->user_laststaffchange) / 86400);

            if($d->user_helper >= 1)
            {
                $d->last_nre = User::last_nre($d->id);
            }
        }

        $me = me();
        $my_nre = null;
        $my_nre_time = null;

        if(is_object($me) && $me->user_helper >= 1)
        {
            $my_nre = User::last_nre($me->id);
            $my_nre_time = User::last_nre_time($me->id);
        }

        return view('main.staff')->with('data', $data)->with('groups', $groups)->with('me', $me)->with('auth', Auth::check())->with('my_nre', $my_nre)->with('my_nre_time', $my_nre_time)->with('complaints_7d', $complaints_7d)->with('complaints_24h', $complaints_24h)->with('newbie', $newbie);
    }
    public function search()
    {
        return view('main.search', ['queried' => false]);
    }

    public function searchPost()
    {
        if(strlen($_POST['sname']) < 3)
        {
            session()->flash('error', 'Nickname prea scurt. Introdu cel putin 3 caractere pentru a cauta un user.');
            return view('main.search', ['queried' => false]);
        }

        $data = DB::table('users')->where('name', 'like', '%'.$_POST['sname'].'%')->select('id', 'name', 'user_level')->orderBy('user_level', 'desc')->limit(50)->get();

        if($data->isEmpty())
        {
            session()->flash('error', 'Nu a fost gasit niciun jucator.');
            return view('main.search', ['queried' => false]);
        }

        if($data->count() == 50)
        {
            session()->flash('error', 'Sunt afisate doar primele 50 de rezultate. Daca nu gasesti jucatorul pe care il cauti, incearca sa introduci o parte mai mare din numele acestuia.');
        }

        return view('main.search', ['queried' => true, 'data' => $data]);
    }

    public function bids()
    {
        $houses = Cache::remember('bids_houses', 5, function() {
            return DB::table('houses')->where('house_ownerid', '=', 0)->select('id', 'house_exterior_posX', 'house_exterior_posY')->get();
        });
        $biz = Cache::remember('bids_biz', 5, function() {
            return DB::table('businesses')->where('biz_ownerid', '=', 0)->select('id', 'biz_exterior_posX', 'biz_exterior_posY')->get();
        });

        return view('main.bids')->with('houses', $houses)->with('biz', $biz);
    }
    public function beta()
    {
        $data = Cache::remember('betapage_testers', 30, function() {
            return DB::table('users')->where('user_beta', '=', '1')->select('id', 'name', 'user_level', 'user_status')->orderBy('id', 'asc')->paginate(50);
        });

        return view('main.beta')->with('data', $data);
    }
    public function banlist()
    {
        $data = Cache::remember('banlist_page', 5, function() {
            return DB::table('bans')->orderBy('ban_id', 'desc')->select('ban_playerid', 'ban_currenttime', 'ban_reason', 'ban_adminname', 'ban_expiretimestamp', 'ban_permanent', 'ban_ipban')->paginate(50);
        });

        return view('main.banlist')->with('data', $data);
    }
}

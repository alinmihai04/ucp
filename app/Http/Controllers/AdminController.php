<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ServerController;
use App\User;
use App\Group;
use DB;
use Cache;

class AdminController extends Controller
{
    public static function beta($user)
    {
    	$userdata = User::fetchUserData($user);

    	if($userdata->user_beta > 0)
    	{
    		DB::table('users')->where('id', '=', $user)->update(['user_beta' => 0]);

    		session()->flash('error', 'Acest utilizator nu mai este Beta Tester.');

    		Cache::forget('userdata'.$user.'');

    		return redirect('/profile/'.$userdata->name.'');
    	}
    	else
    	{
    		DB::table('users')->where('id', '=', $user)->update(['user_beta' => 1]);

    		session()->flash('success', 'Succes! Acest utilizator este acum Beta Tester.');

    		Cache::forget('userdata'.$user.'');

    		return redirect('/profile/'.$userdata->name.'');
    	}
    }

    public static function refresh($user)
    {
        $username = User::getName($user);

        Cache::forget('userdata'.$user);
        Cache::forget('userfh'.$user);
        Cache::forget('lpdata'.$user);
        Cache::forget('banstats'.$user);

        session()->flash('success', 'Profile refreshed!');

        return redirect('/profile/'.$username.'');
    }

    public static function note($user)
    {
        $data = User::fetchUserData($user);

        if(!is_object($data))
        {
            return abort('404');
        }

        return view('admin.note', ['text' => $data->user_admnote, 'user' => $user]);
    }

    public static function notePost($user)
    {

        if($_POST['note'] === '(null)')
        {
            $_POST['note'] = null;
        }

        DB::table('users')->where('id', '=', $user)->update(['user_admnote' => $_POST['note']]);

        $username = User::getName($user);
        $me = me();

        $text = "Admin ".$me->name."[admin:".$me->id."] edited ".$username."[user:".$user."]'s admin note.";

        important_log($user, $me->id, $text, "note");

        Cache::forget('userdata'.$user.'');

        session()->flash('success', $text);
        return redirect('/profile/'.$username.'');
    }

    public static function func($user)
    {
        $data = User::fetchUserData($user);

        if(!is_object($data))
        {
            return abort('404');
        }

        return view('admin.func', ['text' => $data->user_admfunc, 'user' => $user]);
    }

    public static function funcPost($user)
    {
        if($_POST['func'] === '(null)')
        {
            $_POST['func'] = null;
        }

        DB::table('users')->where('id', '=', $user)->update(['user_admfunc' => $_POST['func']]);

        $username = User::getName($user);
        Cache::forget('userdata'.$user.'');

        session()->flash('success', 'Admin function edited!');
        return redirect('/profile/'.$username.'');
    }
    public function fnc($user)
    {
        $validate = User::getName($user);

        if($validate == 'N/A')
        {
            return abort('404');
        }

        return view('admin.fnc')->with('user', $user);
    }
    public function fncPost($user)
    {

        $success = DB::table('users')->where('id', '=', $user)->update(['user_fnc' => 1, 'user_fncreason' => $_POST['reason']]);

        if(!$success)
        {
            session()->flash('error', 'Something went wrong!');
            return redirect('/');
        }

        $me = me();
        $name = User::getName($user);
        $text = "Admin ".$me->name."[admin:".$me->id."] sent a 'FNC' request for user ".$name."[user:".$user."], reason: ".$_POST['reason'];

        important_log($user, $me->id, $text, 'panel fnc');
        session()->flash('success', $text);

        return redirect('/profile/'.$name);
    }

    public static function clearcache()
    {
        Cache::flush();

        session()->flash('success', 'Panel cache cleared (all data refreshed).');

        return redirect('/admin');
    }

    public function controlPanel()
    {
        $player_logs = Cache::remember('plogscount', 120, function() {
            return DB::table('player_logs')->count();
        });
        $important = Cache::remember('implogscount', 120, function() {
            return DB::table('player_importantlogs')->count();
        });
        $kill_logs = Cache::remember('klogscount', 120, function() {
            return DB::table('kill_logs')->count();
        });
        $chat_logs = Cache::remember('clogscount', 120, function() {
            return DB::table('chat_logs')->count();
        });
        $ip_logs = Cache::remember('iplogscount', 120, function() {
            return DB::table('ip_logs')->count();
        });
        $punish_logs = Cache::remember('pplogscount', 120, function() {
            return DB::table('punish_logs')->count();
        });

        $groupdata = Group::loadAllGroups();

        $player_logs += $important;

        $total = $player_logs + $kill_logs + $chat_logs + $ip_logs + $punish_logs;

        return view('admin.control', ['me' => me(), 'player_logs' => $player_logs, 'kill_logs' => $kill_logs, 'chat_logs' => $chat_logs, 'total' => $total, 'ip_logs' => $ip_logs, 'punish_logs' => $punish_logs, 'groupdata' => $groupdata]);
    }

    public function hidefh($user, $fh)
    {
        $fhline = DB::table('faction_logs')->where('id', '=', $fh)->where('player', '=', $user)->select('text', 'hidden')->get();

        if($fhline->isEmpty())
        {
            session()->flash('error', 'Invalid faction log ID.');
            return redirect('/');
        }

        $me = me();
        $name = User::getName($user);
        $fobject = $fhline->first();

        if($fobject->hidden != 1)
        {
            DB::table('faction_logs')->where('id', '=', $fh)->update(['hidden' => 1]);

            $text = "Admin ".$me->name."[admin:".$me->id."] set faction line '".$fobject->text."' status to: hidden";

            important_log($user, $me->id, $text, 'edit');
            session()->flash('success', $text);

            Cache::forget('userfh'.$user);
        }
        else
        {
            DB::table('faction_logs')->where('id', '=', $fh)->update(['hidden' => 0]);

            $text = "Admin ".$me->name."[admin:".$me->id."] set faction line '".$fobject->text."' status to: visible";

            important_log($user, $me->id, $text, 'edit');
            session()->flash('success', $text);

            Cache::forget('userfh'.$user);
        }

        DB::table('faction_logs_history')->insert([['id' => $fh, 'text' => $text, 'user' => $me->id, 'user_name' => $me->name]]);
        return redirect('/profile/'.$name);


    }

    public function editfh($user, $fh)
    {
        $fhline = DB::table('faction_logs')->where('id', '=', $fh)->where('player', '=', $user)->select('text', 'player')->get();

        if($fhline->isEmpty())
        {
            session()->flash('error', 'Invalid faction log ID.');
            return redirect('/');
        }

        return view('admin.editfh')->with('text', $fhline->first()->text)->with('fh', $fh)->with('user', $user);
    }

    public function editfhPost($user, $fh)
    {
        //$fhtext = DB::table('faction_logs')->where('id', '=', $fh)->value('text');
        $return = DB::table('faction_logs')->where('id', '=', $fh)->where('player', '=', $user)->update(['text' => $_POST['fh'], 'edited' => 1]);

        $me = me();
        $url = url('/admin/historyfh/'.$fh);
        $text = "Admin ".$me->name."[admin:".$me->id."] edited faction line[id:".$fh."]: ".$_POST['fh']." - <a href=".$url."> view edit history </a>";

        important_log($user, $me->id, $text, 'edit');
        DB::table('faction_logs_history')->insert([['id' => $fh, 'text' => $_POST['fh'], 'user' => $me->id, 'user_name' => $me->name]]);

        Cache::forget('userfh'.$user);

        session()->flash('success', $text);
        return redirect('/profile/'.User::getName($user));
    }

    public function historyFh($fh)
    {
        $value = DB::table('faction_logs_history')->where('id', '=', $fh)->orderBy('time', 'desc')->get();

        if($value->isEmpty())
        {
            session()->flash('error', 'Invalid data.');
            return redirect('/');
        }

        return view('admin.history')->with('data', $value);
    }
    public function remove($user)
    {
        $data = User::fetchUserData($user);

        if(!is_object($data))
        {
            session()->flash('error', 'Something went wrong.');
            return redirect('/');
        }
        if($data->user_admin == 0 && $data->user_helper == 0)
        {
            session()->flash('error', 'Invalid user.');
            return redirect('/');
        }

        $me = me();

        DB::table('users')->where('id', '=', $user)->update(['user_admin' => 0, 'user_helper' => 0]);

        $log = "Admin ".$me->name."[admin:".$me->id."] removed ".$data->name."[user:".$data->id."] from the staff (helper ".$data->user_helper.", admin ".$data->user_admin.").";

        staff_log($log);
        important_log($user, $me->id, $log, 'staff');

        session()->flash('info', 'This player is no longer in staff.');

        Cache::forget('userdata'.$data->id);

        return redirect('/profile/'.$data->name);
    }
    public function unban($user)
    {
        $me = me();
        $username = User::getName($user);

        DB::table('bans')->where('ban_playername', '=', $username)->update(['ban_expiretimestamp' => 0]);

        $log = "Admin ".$me->name."[admin:".$me->id."] unbanned ".$username."[user:".$user."] from the panel.";

        important_log($me->id, 0, $log, 'unban');
        punish_log($user, $log);

        session()->flash('success', $log);

        return redirect('/profile/'.$username);
    }
    public function givepp($user)
    {
        return view('admin.givepp')->with('user', $user);
    }
    public function giveppPost($user)
    {
        $amount = intval($_POST['amount']);

        if(!is_int($amount) || empty($_POST['amount']))
        {
            session()->flash('error', 'Invalid amount / empty amount.');
            return redirect('/admin/givepp/' . $user);
        }

        $data = User::fetchUserData($user);

        if(!is_object($data))
        {
            session()->flash('error', 'Something went wrong.');
            return redirect('/');
        }
        if($amount < 0 && $data->user_premiumpoints + $amount < 0)
        {
            session()->flash('error', "This player has only " . $data->user_premiumpoints . " premium points.");
            return redirecT('/admin/givepp/' . $user);
        }

        $me = me();

        DB::statement("UPDATE `users` SET `user_premiumpoints`=`user_premiumpoints` + " . $amount . " WHERE `id`=" . $data->id);

        $log = "Admin " .  $me->name . "[admin:" . $me->id . "] added " . $amount . " premium points into " . $data->name . "[user:" . $data->id . "]'s account.";

        important_log($me->id, $data->id, $log, "pp");

        Cache::forget('userdata' . $user);

        session()->flash('success', $log);
        return redirect('/profile/' . $data->name);
    }
    public function money($user)
    {
        $data = User::fetchUserData($user);
        return view('admin.money')->with('user', $user)->with('bank', $data->user_bankmoney)->with('cash', $data->user_money);
    }
    public function moneyEdit($user)
    {
        $money = intval($_POST['money']);

        if(!is_int($money) || empty($_POST['money']) || $money == 0)
        {
            session()->flash('error', 'Valoare invalida!');
            return redirect('/admin/money/' . $user);
        }

        $data = User::fetchUserData($user);
        $me = me();

        if($money < 0)
        {
            if($data->user_money >= $money)
            {
                $data->user_money -= $money;
            }
            else if($data->user_bankmoney >= $money)
            {
                $data->user_bankmoney -= $money;
            }
            else if($data->user_money + $data->user_bankmoney >= $money)
            {
                $data->user_bankmoney += $data->user_money;
                $data->user_bankmoney -= $money;
                $data->user_money = 0;
            }
            else
            {
                session()->flash('error', 'Acest jucator nu are atatia bani.');
                return redirect('/admin/money/' . $user);
            }

            $txt = "AdmPanel: User " . $data->name . "[user:" . $data->id . "]'s money were modified by Admin " . $me->name . ": -$" . number_format($money);
            $modifier = 1;
        }
        else
        {
            $data->user_bankmoney += $money;

            $txt = "AdmPanel: User " . $data->name . "[user:" . $data->id . "]'s money were modified by Admin " . $me->name . ": +$" . number_format($money);
            $modifier = 2;
        }

        ServerController::sendPanelAction($data->id, 8, $modifier, $money, $txt);

        if($modifier == 2)
        {
            $log = "Admin " . $me->name . "[admin:" . $me->id . "] edited user " . $data->name . "[user:" . $data->id . "]'s money: +$" . number_format($money);
        }
        else
        {
            $log = "Admin " . $me->name . "[admin:" . $me->id . "] edited user " . $data->name . "[user:" . $data->id . "]'s money: -$" . number_format($money);
        }

        User::where('id', '=', $data->id)->update(['user_money' => $data->user_money, 'user_bankmoney' => $data->user_bankmoney]);

        admin_log($me->id, $data->id, $log);
        session()->flash('success', $log);

        Cache::forget('userdata' . $user);
        return redirect('/profile/' . $data->name);
    }
    public function support($level, $user)
    {
        Cache::forget('userdata' . $user);
        $userdata = User::fetchUserData($user);

        if(!is_object($userdata))
        {
            session()->flash('error', 'Invalid player data.');
            return redirect('/staff');
        }
        if($userdata->user_admin <= 0)
        {
            session()->flash('error', 'This player is not an admin.');
            return redirect('/profile/' . $userdata->name);
        }

        DB::table('users')->where('id', '=', $user)->update(['user_support' => $level]);

        $userdata->user_support = $level;
        $me = me();
        $log = "Admin action: " . $me->name . " set " . $userdata->name . "[admin:" . $userdata->id . "]'s support level to " . $level . ".";

        important_log($userdata->id, $me->id, $log, 'support');
        session()->flash('success', $log);

        Cache::forget('userdata' . $user);
        Cache::add('userdata' . $user, $userdata, 5);

        return redirect('/profile/' . $userdata->name);
    }
    public function complaintMoney($topic)
    {
        $money = intval($_POST['money']);
        $user = $_POST['player'];

        if(!is_int($money) || empty($_POST['money']) || $money == 0)
        {
            session()->flash('error', 'Valoare invalida!');
            return redirect('/complaint/view/' . $topic);
        }

        $data = User::fetchUserData($user);
        $me = me();

        if($money < 0)
        {
            if($data->user_money >= $money)
            {
                $data->user_money -= $money;
            }
            else if($data->user_bankmoney >= $money)
            {
                $data->user_bankmoney -= $money;
            }
            else if($data->user_money + $data->user_bankmoney >= $money)
            {
                $data->user_bankmoney += $data->user_money;
                $data->user_bankmoney -= $money;
                $data->user_money = 0;
            }
            else
            {
                session()->flash('error', 'Acest jucator nu are atatia bani.');
                return redirect('/admin/money/' . $user);
            }

            $txt = "AdmPanel: User " . $data->name . "[user:" . $data->id . "]'s money were modified by Admin " . $me->name . ": -$" . number_format($money);
            $modifier = 1;
        }
        else
        {
            $data->user_bankmoney += $money;

            $txt = "AdmPanel: User " . $data->name . "[user:" . $data->id . "]'s money were modified by Admin " . $me->name . ": +$" . number_format($money);
            $modifier = 2;
        }

        ServerController::sendPanelAction($data->id, 8, $modifier, $money, $txt);

        if($modifier == 2)
        {
            $log = "Admin " . $me->name . "[admin:" . $me->id . "] edited user " . $data->name . "[user:" . $data->id . "]'s money: +$" . number_format($money);
        }
        else
        {
            $log = "Admin " . $me->name . "[admin:" . $me->id . "] edited user " . $data->name . "[user:" . $data->id . "]'s money: -$" . number_format($money);
        }

        User::where('id', '=', $data->id)->update(['user_money' => $data->user_money, 'user_bankmoney' => $data->user_bankmoney]);

        admin_log($me->id, $data->id, $log);
        session()->flash('success', $log);

        Cache::forget('userdata' . $user);
        return redirect('/complaint/view/' . $topic);
    }
    public function group_skins($group)
    {
        $data = DB::table('f_skins')->where('group_id', '=', $group)->select('skin_id')->orderBy('skin_id', 'asc')->get();

        return view('group.skins')->with('data', $data)->with('group', $group);
    }
    public function group_skins_add($group)
    {
        $skin = $_POST['skin'];

        if($skin < 0 || $skin > 311)
        {
            session()->flash('error', 'Invalid skin.');
            return redirect('/group/skins/' . $group);
        }

        DB::table('f_skins')->insert([['group_id' => $group, 'skin_id' => $skin]]);

        session()->flash('success', 'Skin added (' . $skin . ').');
        return redirect('/group/skins/' . $group);
    }
    public function group_skins_remove($group, $skin)
    {
        if($skin < 0 || $skin > 311)
        {
            session()->flash('error', 'Invalid skin.');
            return redirect('/group/skins/' . $group);
        }

        DB::table('f_skins')->where('group_id', '=', $group)->where('skin_id', '=', $skin)->delete();

        session()->flash('error', 'Skin removed (' . $skin . ').');
        return redirect('/group/skins/' . $group);
    }
    public function viewGroupslots($group)
    {
        $data = Group::where('group_id', '=', $group)->get()->first();

        if(!is_object($data))
        {
            session()->flash('error', 'Invalid group data.');
            return redirect('/admin');
        }

        return view('admin.editgroup')->with('editAttr', 'slots')->with('group', $data);
    }
    public function processGroupslots($group)
    {
        if(!isset($_POST['slots']) || !is_numeric($_POST['slots']) || $_POST['slots'] < 0)
        {
            session()->flash('error', 'Invalid slots value');
            return redirect('/admin');
        }

        DB::table('groups')->where('group_id','=',$group)->update(['group_slots'=>$_POST['slots']]);

        $me = me();
        $log = "Admin " . $me->name . "[admin:" . $me->id . "] changed [group:" . $group . "] slots to " . $_POST['slots'] . ".";
        important_log($me->id, 0, $log, "edit group");

        session()->flash('success', 'Group id ' . $group . ' slots changed to ' . $_POST['slots']);
        return redirect('/admin');
    }
    public function viewGroupLevel($group)
    {
        $data = Group::where('group_id', '=', $group)->get()->first();

        if(!is_object($data))
        {
            session()->flash('error', 'Invalid group data.');
            return redirect('/admin');
        }

        return view('admin.editgroup')->with('editAttr', 'level')->with('group', $data);
    }
    public function processGrouplevel($group)
    {
        if(!isset($_POST['level']) || !is_numeric($_POST['level']) || $_POST['level'] < 0)
        {
            session()->flash('error', 'Invalid level value');
            return redirect('/admin');
        }

        DB::table('groups')->where('group_id','=',$group)->update(['group_level'=>$_POST['level']]);

        $me = me();
        $log = "Admin " . $me->name . "[admin:" . $me->id . "] changed [group:" . $group . "] level to " . $_POST['level'] . ".";
        important_log($me->id, 0, $log, "edit group");

        session()->flash('success', 'Group id ' . $group . ' level changed to ' . $_POST['level']);
        return redirect('/admin');
    }
}

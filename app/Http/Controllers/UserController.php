<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ServerController;
use App\User;
use App\Vehicle;
use App\House;
use App\Business;
use App\Job;
use App\Group;
use App\Complaint;
use Auth;
use DB;
use Cache;
use Hash;

class UserController extends Controller
{
    public function profile($user)
    {
    	if(is_numeric($user))
    	{
    		$tmp = User::fetchUserData($user);

    		if(!is_object($tmp))
    		{
    			abort('404');
    		}

            User::setInternalId($tmp->name, $tmp->id);

    		return redirect('/profile/'.$tmp->name);
    	}

        $sqlid = User::getInternalId($user);
    	$data = User::fetchUserData($sqlid);

        if(!is_object($data))
        {
            return abort('404');
        }

        $me = me();

        if($data->user_shownskin == 0)
        {
            $data->user_skin = $data->user_groupskin;
        }

        if(Auth::check())
        {
            if($me->user_admin > 0)
            {
                $lpdata = User::getPlayerLastPunish($data->id);
                $complaints = Cache::remember('usercomplaints' . $data->id, 5, function() use ($sqlid) {
                    return DB::table('panel_topics')->whereRaw('type = 1 AND (user_id='.$sqlid.' OR creator_id='.$sqlid.')')->select('id', 'time', 'user_name', 'creator_name', 'creator_id', 'user_id', 'reason')->get();
                });

                return view('user.profile', ['data' => $data, 'vehicles' => Vehicle::getPlayerVehicles($sqlid), 'house' => House::getHouseData($data->user_house)->first(), 'biz' => Business::getBizzData($data->user_business)->first(), 'flog' => User::getPlayerFactionLogs($sqlid), 'me' => $me, 'auth' => Auth::check(), 'banstats' => User::getPlayerBanStatus($sqlid), 'fw' => Group::getUserGroupFW($data->user_group), 'jobname' => Job::getJobName($data->user_job), 'lpdata' => $lpdata, 'complaints' => $complaints, 'friends' => User::getFriends($sqlid)]);
            }

        }

    	return view('user.profile', ['data' => $data, 'vehicles' => Vehicle::getPlayerVehicles($sqlid), 'house' => House::getHouseData($data->user_house)->first(), 'biz' => Business::getBizzData($data->user_business)->first(), 'flog' => User::getPlayerFactionLogs($sqlid), 'me' => $me, 'auth' => Auth::check(), 'banstats' => User::getPlayerBanStatus($sqlid), 'fw' => Group::getUserGroupFW($data->user_group), 'jobname' => Job::getJobName($data->user_job), 'friends' => User::getFriends($sqlid)]);
    }
    public function notifications()
    {
        if(Auth::check())
        {
            $data = DB::table('emails')->where('playerid', '=', Auth::id())->orderBy('id', 'desc')->limit(10)->get();

            DB::table('emails')->where('playerid', '=', Auth::id())->update(['seen' => 1]);

            Cache::forget('useremails' . Auth::id());

            if($data->isEmpty())
            {
                $data = null;
            }
        }
        else
        {
            $data = null;
        }

        return view('user.notifications')->with('data', $data);
    }

    public function userbar($name)
    {
        $user = User::fetchUserData(User::getInternalId($name));

        if(!is_object($user))
        {
            return abort('404');
        }


        $img = imagecreatefrompng(url('/images/userbar/pic.png'));
        $text_color = imagecolorallocate($img, 197,197,199);
        $color_white = imagecolorallocate($img, 250, 250, 250);
        $color_black = imagecolorallocate($img, 0, 0, 0);
        $colorRed = ImageColorAllocate($img, 116, 106, 105);
        $colorOrange = ImageColorAllocate($img, 255, 130, 0);
        $colorGreen = ImageColorAllocate($img,0,255,0);
        $colorHotRed = ImageColorAllocate($img, 227, 38, 54);

        $skin = url('/images/userbar_skins/Skin_' . $user->user_skin . '.png');
        $im = ImageCreateFromPNG($skin);

        ImageCopy($img,$im, 130, 22,0,0,55,100);

        $font = public_path() . '/images/userbar/calibril.ttf';

        imagettftext($img, 10, 0.0, 190, 30, $color_white, $font, "Nick: " .$user->name);
        ImageTTFText($img, 10, 0.0, 190, 43, $color_white, $font, "Level: ".$user->user_level);
        ImageTTFText($img, 10, 0.0, 190, 56, $color_white, $font, "Respect points: ".$user->user_rp);
        ImageTTFText($img, 10, 0.0, 190, 69, $color_white, $font, "Hours played: ".$user->user_hours);
        ImageTTFText($img, 10, 0.0, 190, 82, $color_white, $font, "Phone number: ".$user->user_phonenr);
        ImageTTFText($img, 10, 0.0, 190, 95, $color_white, $font, "Job: ".Job::getJobName($user->user_job));
        if($user->user_group > 0)
        {
            ImageTTFText($img, 10, 0.0, 190, 108, $color_white, $font, "Faction: ".Group::getGroupName($user->user_group));
        }
        else
        {
            ImageTTFText($img, 10, 0.0, 190, 108, $color_white, $font, "Faction: Civilian");
        }
        if($user->user_grouprank != 0)
            ImageTTFText($img, 10, 0.0, 190, 121, $color_white, $font, "Rank: ".$user->user_grouprank);
        else if($user->user_grouprank == 0)
            ImageTTFText($img, 10, 0.0, 190, 121, $color_white, $font, "Rank: N/A");

        if($user->user_status == 1)
            ImageTTFText($img, 12, 0.0, 340, 20, $colorGreen, $font, 'Online');
        else if($user->user_status == 2)
            ImageTTFText($img, 12, 0.0, 340, 20, $colorOrange, $font, 'Sleeping');
        else
            ImageTTFText($img, 12, 0.0, 340, 20, $colorHotRed, $font, 'Offline');

        ImageTTFText($img, 8, 0.0, 5, 10, $colorHotRed, $font, config('app.title') . " DEBUG VERSION");

        header('Content-Type: image/jpeg');
        $image = imagepng($img);
        imagedestroy($img);
    }

    public static function warn($user, $admin, $reason, $topic)
    {
        $u = User::fetchUserData($user);

        if(!is_object($u))
        {
            return redirect('/');
        }

        $a = User::fetchUserData($admin);

        if(!is_object($a) || $a->user_admin == 0)
        {
            return redirect('/');
        }

        $warns = $u->user_warns + 1;

        if($topic == 0)
        {
            $topic_text = null;
        }
        else
        {
            $topic_text = " [complaint:" . $topic ."]";
        }


        $warn_text = "AdmPanel: " . $u->name . " has been warned by " . $a->name . ", reason: " . $reason . "." . $topic_text;

        DB::table('panel_actions')->insert([['action_id' => 1, 'user_id' => $user, 'action_text' => $warn_text]]);

        if($warns >= 3)
        {
            $expiretimestamp = time() + 259200;

            $text = "AdmPanel: " . $u->name . " has been banned by AdmBot for 3 days, reason: 3/3 warns";

            DB::table('bans')->insert([['ban_playername' => $u->name, 'ban_adminname' => 'AdmBot', 'ban_days' => 3, 'ban_reason' => '3/3 warns', 'ban_ip' => $u->last_ip, 'ban_permanent' => 0,'ban_expiretimestamp' => $expiretimestamp, 'ban_gpci' => $u->user_gpci, 'ban_currenttimestamp' => time()]]);
            DB::table('panel_actions')->insert([['action_id' => 2, 'user_id' => $user, 'action_text' => $text]]);

            DB::table('users')->where('id', '=', $user)->update(['user_warns' => 0]);
        }
        else
        {
            DB::table('users')->where('id', '=', $user)->update(['user_warns' => $warns]);
        }
    }
    public static function jail($user, $admin, $time, $reason, $suspend, $topic)
    {
        Cache::forget('userdata' . $user);
        $u = User::fetchUserData($user);

        if(!is_object($u))
        {
            return redirect('/');
        }

        $a = User::fetchUserData($admin);

        if(!is_object($a) || $a->user_admin == 0)
        {
            return redirect('/');
        }

        if($topic == 0)
        {
            $topic_text = null;
        }
        else
        {
            $topic_text = " [complaint:" . $topic ."]";
        }

        $jail_text = "AdmPanel: " . $u->name . " has been jailed by " . $a->name . " for " . $time . " minutes, reason: " . $reason . "." . $topic_text;

        $jailtime = ($time * 60) + $u->user_jailtime;

        if($u->user_wanted >= 1)
        {
            $jailtime += $u->user_wanted * 300;
        }

        if($suspend == 1)
        {
            $gunlic = 0;
            $gunsus = (3 + $time / 10) + $u->user_gunlicsuspend;
        }
        else
        {
            $gunlic = $u->user_gunlic;
            $gunsus = $u->user_gunlicsuspend;
        }

        DB::table('panel_actions')->insert([['action_id' => 10, 'user_id' => $user, 'action_text' => $jail_text, 'action_time' => $time, 'action_value' => $suspend]]);
        DB::table('users')->where('id', '=', $u->id)->update(['user_jail' => 2, 'user_jailtime' => $jailtime, 'user_gunlic' => $gunlic, 'user_gunlicsuspend' => $gunsus]);
    }
    public static function mute($user, $admin, $time, $reason, $topic)
    {
        Cache::forget('userdata' . $user);
        $u = User::fetchUserData($user);

        if(!is_object($u))
        {
            return redirect('/');
        }

        $a = User::fetchUserData($admin);

        if(!is_object($a) || $a->user_admin == 0)
        {
            return redirect('/');
        }

        if($topic == 0)
        {
            $topic_text = null;
        }
        else
        {
            $topic_text = " [complaint:" . $topic ."]";
        }

        $mute_text = "AdmPanel: " . $u->name . " has been muted by " . $a->name . " for " . $time . " minutes, reason: " . $reason . "." . $topic_text;

        $mute_time = ($time * 60) + $u->user_mute;

        DB::table('panel_actions')->insert([['action_id' => 11, 'user_id' => $user, 'action_text' => $mute_text, 'action_time' => $mute_time]]);
        DB::table('users')->where('id', '=', $u->id)->update(['user_mute' => $mute_time]);
    }
    public static function ban($user, $admin, $reason, $time, $topic)
    {
        if($time < 0 || $time > 999)
        {
            session()->flash('error', 'Something went wrong.');
            return redirect('/');
        }

        $u = User::fetchUserData($user);

        if(!is_object($u))
        {
            return redirect('/');
        }

        $a = User::fetchUserData($admin);

        if(!is_object($a) || $a->user_admin == 0)
        {
            return redirect('/');
        }

        if($topic == 0)
        {
            $topic_text = null;
        }
        else
        {
            $topic_text = " [complaint:" . $topic ."]";
        }

        if($time == 999)
        {
            $ban_text = "AdmPanel: " . $u->name . " has been permanent banned by " . $a->name . ", reason: " . $reason . "." . $topic_text;
        }
        else
        {
            $ban_text = "AdmPanel: " . $u->name . " has been banned by " . $a->name . " for " . $time .  " days, reason: " . $reason . "." . $topic_text;
        }

        DB::table('panel_actions')->insert([['action_id' => 2, 'user_id' => $user, 'action_text' => $ban_text]]);

        if($time == 999)
        {
            DB::table('bans')->insert([['ban_playername' => $u->name, 'ban_playerid' => $u->id, 'ban_adminid' => $a->id, 'ban_adminname' => $a->name, 'ban_days' => 0, 'ban_reason' => $reason, 'ban_ip' => $u->last_ip, 'ban_permanent' => 1,'ban_expiretimestamp' => 0, 'ban_gpci' => $u->user_gpci, 'ban_currenttimestamp' => time()]]);
        }
        else
        {
            DB::table('bans')->insert([['ban_playername' => $u->name, 'ban_playerid' => $u->id, 'ban_adminid' => $a->id, 'ban_adminname' => $a->name, 'ban_days' => $time, 'ban_reason' => $reason, 'ban_ip' => $u->last_ip, 'ban_permanent' => 0,'ban_expiretimestamp' => time() + (86400 * $time), 'ban_gpci' => $u->user_gpci, 'ban_currenttimestamp' => time()]]);
        }
    }

    public function decon($user)
    {
        if(!Auth::check())
        {
            return redirect('/login');
        }

        if($user != Auth::id())
        {
            session()->flash('error', 'Unauthorized access.');
            return redirect('/');
        }

        Cache::forget('userdata' . $user);

        $me = me();

        if($me->last_ip == \Request::ip())
        {
            session()->flash('error', 'IP-ul din joc nu difera fata de IP-ul tau actual.');
            return redirect('/');
        }
        if($me->user_status == 0)
        {
            session()->flash('error', 'Contul tau nu este online pe server.');
            return redirect('/');
        }

        $text = "Cineva a cerut deconectarea ta de pe server. IP: " . \Request::ip();

        important_log($me->id, 0, $text, 'panel');

        ServerController::sendPanelAction($me->id, 9, 0, 0, $text);

        session()->flash('success', 'Contul tau va fi deconectat de pe server in maxim 30 de secunde.');
        return redirect('/');
    }
    public function hours($user)
    {
        $last30 = Cache::remember('last30' . $user, 60, function() use ($user) {
            return DB::table('player_activity')->where('time', '>=', 'DATE_SUB(CURDATE(), INTERVAL 30 DAY)')->where('player', '=', $user)->orderBy('id', 'desc')->get();
        });

        $last7_avg = intval($last30->sortByDesc('id')->take(7)->sum('seconds') / 7);
        $last30_avg = intval($last30->sum('seconds') / 30);

        return view('user.hours')->with('last7_avg', $last7_avg)->with('last30_avg', $last30_avg)->with('last30', $last30)->with('name', User::getName($user));
    }
    public function allnotifications()
    {
        $id = Auth::id();
        $data = Cache::remember('notifications' . $id, 2, function() use ($id) {
            return DB::table('emails')->where('playerid', '=', $id)->orderBy('id', 'desc')->limit(100)->get();
        });

        return view('user.allnotifications')->with('data', $data);
    }
    public function shownskin($show)
    {
        $me = me();

        if(!is_object($me))
        {
            session()->flash('error', 'Invalid data.');
            return redirect('/');
        }

        DB::table('users')->where('id', '=', $me->id)->update(['user_shownskin' => $show]);

        $text = ($show) == 0 ? 'skin-ul factiunii din care faci parte.' : 'skin-ul normal (de civil).';

        session()->flash('success', 'Optiune schimbata, acum pe profilul tau o sa fie afisat ' . $text . '<br>O sa dureze cateva minute pana cand schimbarea va fi vizibila.');
        return redirect('/profile/' . $me->name);
    }
    public function viewChangemail($user)
    {
        $me = me();
        $u = User::fetchUserData($user);

        if($me->user_admin < 5 && $me->id != $u->id)
        {
            session()->flash('error', 'Unauthorized access!');
            return redirect('/profile/' . $user);
        }

        return view('user.changemail')->with('userdata', $u);
    }
    public function processChangemail($user)
    {
        if(!isset($_POST['new_email']) || !isset($_POST['c_password']))
        {
            session()->flash('error', 'Completeaza toate campurile!');
            return redirect('/user/changemail/' . $user);
        }

        $me = me();
        $u = User::fetchUserData($user);

        if($me->user_admin < 5 && $me->id != $u->id)
        {
            session()->flash('error', 'Unauthorized access!');
            return redirect('/profile/' . $user);
        }

        if(!Hash::check($_POST['c_password'], $me->password))
        {
            session()->flash('error', 'Parola introdusa nu corespunde cu cea a contului!');
            return redirect('/user/changemail/' . $user);
        }

        DB::table('users')->where('id', '=', $user)->update(['user_email'=>$_POST['new_email']]);

        if($me->user_admin >= 5 && $me->id != $u->id)
        {
            $log = "Admin ".$me->name."[admin:".$me->id."] changed user ".$u->name."[user:".$u->id."]'s email to: " . $_POST['new_email'] . ".";

            important_log($me->id, $u->id, $log, 'email change');
        }
        else if($me->id == $u->id)
        {
            $log = "User ".$u->name."[user:".$u->id."] changed his email to: " . $_POST['new_email'] . ".";

            important_log($me->id, $u->id, $log, 'email change');
        }

        session()->flash('success', 'Email changed to: ' . $_POST['new_email']);

        Cache::forget('userdata' . $u->id);

        return redirect('/profile/' . $u->name);
    }
}

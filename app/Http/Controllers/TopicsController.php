<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Cache;
use DB;
use App\Complaint;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

class TopicsController extends Controller
{
    public function myComplaints()
    {

        $data = Cache::remember('mycomplaints', 5, function() {
            return DB::table('panel_topics')->where('type', '=', 1)->where('creator_id', '=', me()->id)->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
        });
        return view('main.complaints')->with('data', $data)->with('mycomplaints', 1);
    }
    public function complaintsList()
    {
    	$data = Cache::remember('complaints', 5, function() {
    		return DB::table('panel_topics')->where('type', '=', 1)->where('reason', '!=', 2)->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
    	});
    	return view('main.complaints')->with('data', $data);
    }
    public function complaintsListFilter($type)
    {
    	switch($type)
    	{
    		case 'normal':
    		{
		    	$data = Cache::remember('complaints_filter' . $type, 1, function() {
		    		return DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 0)->where('reason', '!=', 2)->where('reason', '!=', 4)->where('reason', '!=', 6)->where('reason', '!=', 7)->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.user_name', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
		    	});
    			break;
    		}
    		case 'leader':
    		{
		    	$data = Cache::remember('complaints_filter' . $type, 1, function() {
		    		return DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 0)->where('reason', '=', '7')->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.user_name', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
		    	});
    			break;
    		}
    		case 'staff':
    		{
		    	$data = Cache::remember('complaints_filter' . $type, 1, function() {
		    		return DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 0)->where('reason', '=', '6')->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.user_name', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
		    	});
    			break;
    		}
    		case 'scam':
    		{
		    	$data = Cache::remember('complaints_filter' . $type, 1, function() {
		    		return DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 0)->where('reason', '=', '4')->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.user_name', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
		    	});
    			break;
    		}
    		case 'owner':
    		{
		    	$data = Cache::remember('complaints_filter' . $type, 1, function() {
		    		return DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 2)->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.user_name', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
		    	});
    			break;
    		}
    	}

    	return view('main.complaints')->with('data', $data);
    }
    public function view($topic)
    {
    	$data = Cache::remember('topicdata' . $topic, 60, function() use ($topic) {
    		return DB::table('panel_topics')->where('id', '=', $topic)->get()->first();
    	});

    	if(!is_object($data))
    	{
    		session()->flash('error', 'Invalid topic data.');
    		return redirect('/');
    	}

    	if(Auth::check())
    	{
    		$me = me();
    	}
    	else
    	{
    		$me = null;
    	}

    	if($data->status == 3 && (!is_object($me) || $me->user_admin == 0))
    	{
    		session()->flash('error', 'You cannot view deleted topics.');
    		return redirect('/complaints');
    	}

     	$posts = Cache::remember('topicposts' . $topic, 15, function() use ($topic) {
    		return DB::table('panel_posts')->where('topic', '=', $topic)->join('users', 'users.id', '=', 'panel_posts.user_id')->select('panel_posts.*', 'name', 'user_skin', 'user_admin', 'user_helper', 'user_grouprank')->get();
    	});

    	$creator = User::fetchUserData($data->creator_id);
        $against = User::fetchUserData($data->user_id);

    	if(!is_object($creator))
    	{
       		session()->flash('error', 'Invalid topic data.');
    		return redirect('/');
    	}

    	if(is_object($me) && $me->user_admin > 0)
    	{
            if($data->reason == 4)
            {
                $logs = User::getPlayerLastTransactions($data->user_id);
            }
            else
            {
               $logs = User::getPlayerLastPunish($data->user_id);
            }

    		return view('complaint.view')->with('data', $data)->with('creator', $creator)->with('against', $against)->with('posts', $posts)->with('me', $me)->with('logs', $logs);
    	}

    	return view('complaint.view')->with('data', $data)->with('creator', $creator)->with('against', $against)->with('posts', $posts)->with('me', $me);
    }
    public function complaintCreate($user)
    {
    	if($user == Auth::id())
    	{
    		session()->flash('error', "Nu iti poti face reclamatie singur! <br>Cauta playerul caruia vrei sa ii faci reclamatie!
				You can't make a complaint to yourself");
			return redirect('/search');
    	}

    	$data = User::fetchUserData($user);

    	if(!is_object($data))
    	{
    		session()->flash('error', 'Invalid data.');
    		return redirect('/complaints');
    	}

    	return view('complaint.create')->with('data', $data);
    }
    public function complaintCreatePost($user)
    {
    	if(empty($_POST['links']) || empty($_POST['desc']))
    	{
    		session()->flash('error', 'Completeaza toate campurile!');
    		return redirect('/complaint/create/' . $user);
    	}

     	$me = me();

    	if(!is_object($me))
    	{
    		session()->flash('error', 'You need to login first.');
    		return redirect('/login');
    	}

    	if($user == $me->id)
    	{
    		session()->flash('error', "Nu iti poti face reclamatie singur! <br>Cauta playerul caruia vrei sa ii faci reclamatie!
				You can't make a complaint to yourself");
			return redirect('/search');
    	}

    	$data = User::fetchUserData($user);

    	if(!is_object($data))
    	{
    		session()->flash('error', 'Invalid data.');
    		return redirect('/complaints');
    	}

    	if($_POST['reason'] == 2 && $data->user_group == 0)
    	{
    		session()->flash('error', 'This user has no faction.');
    		return redirect('/profile/' . $data->name);
    	}
     	if($_POST['reason'] == 6 && $data->user_admin == 0 && $data->user_helper == 0)
    	{
    		session()->flash('error', 'This user has is not an admin / helper.');
    		return redirect('/profile/' . $data->name);
    	}
     	if($_POST['reason'] == 7 && $data->user_grouprank < 7)
    	{
    		session()->flash('error', 'This user has is not a faction leader');
    		return redirect('/profile/' . $data->name);
    	}

    	$faction = $_POST['reason'] == 2 ? $data->user_group : 0;

    	$id = DB::table('panel_topics')->insertGetId(['type' => 1, 'user_name' => $data->name, 'creator_name' => $me->name, 'user_id' => $data->id, 'creator_id' => $me->id, 'reason' => $_POST['reason'], 'evidence' => $_POST['links'], 'details' => $_POST['desc'], 'faction' => $faction, 'ip' => \Request::ip()]);

    	$email = "RECLAMATIE: " . $me->name . " ti-a facut o reclamatie. O poti gasi pe user panel.";

    	email($user, $email, '/complaint/view/' . $id);

    	session()->flash('success', 'Complaint posted!');
    	return redirect('/complaint/view/' . $id);
    }
    public function complaintRespond($complaint)
    {
        $me = me();

        $topicdata = Cache::get('topicdata' . $complaint);

        if(!is_object($topicdata))
        {
            session()->flash('error', 'Something went wrong.');
            return redirect('/complaint/view/' . $complaint);
        }

        if(!is_object($me) || $me->user_admin == 0)
        {
            session()->flash('error', 'Unathorized access.');
            return redirect('/');
        }

        if(isset($_POST['warn']))
        {
            if(empty($_POST['reason']))
            {
                session()->flash('error', "Completeaza campul 'reason'.");
                return redirect('/complaint/view/' . $complaint);
            }

            UserController::warn($topicdata->user_id, $me->id, $_POST['reason'], $complaint);

            $text = "Admin " . $me->name . " <b>warned</b> player <b>" . User::getName($topicdata->user_id) . "</b>, reason: <b>" . $_POST['reason'] . "</b>";

            $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ".";

            email($topicdata->user_id, $email, '/complaint/view/' . $complaint);

            PostController::addPost($complaint, $text, me());

            $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been warned by " . $me->name . "[admin:" . $me->id . "], reason: " . $_POST['reason'] . ".";

            punish_log($topicdata->user_id, $log);

            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 1, 'responser' => $me->id]);

            Cache::forget('topicdata' . $complaint);

            session()->flash('This player has been warned.');
            return redirect('/complaint/view/' . $complaint);
        }
        else if(isset($_POST['dm']))
        {
            $dmtimes = DB::table('punish_logs')->where('playerid', '=', $topicdata->user_id)->where('text', 'like', '%%jailed%%')->where('time', '>=', 'DATE_SUB(CURDATE(), INTERVAL 30 DAY)')->count('*');

            $jailtime = intval((1200 + ($dmtimes * 600)) / 60);

            if($jailtime > 60)
            {
                $jailtime = 60;
            }

            $text = "Admin " . $me->name . " <b>jailed</b> player <b>" . User::getName($topicdata->user_id) . "</b> for <b>" . $jailtime . "</b> minutes, reason: <b>DM</b>";
            $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ". Ai primit jail pentru " . $jailtime . " minute in urma acesteia.";
            $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been jailed by " . $me->name . "[admin:" . $me->id . "] for " . $jailtime . " minutes, reason: DM.";

            email($topicdata->user_id, $email, '/complaint/view/' . $complaint);

            PostController::addPost($complaint, $text, me());
            punish_log($topicdata->user_id, $log);

            UserController::jail($topicdata->user_id, $me->id, $jailtime, "DM", 1, $complaint);

            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 1, 'responser' => $me->id]);
            Cache::forget('topicdata' . $complaint);

            session()->flash('This player has been jailed for ' . $jailtime . " minutes with licence suspended.");
            return redirect('/complaint/view/' . $complaint);
        }
        else if(isset($_POST['dmp']))
        {
            $dmtimes = DB::table('punish_logs')->where('playerid', '=', $topicdata->user_id)->where('text', 'like', '%%jailed%%')->where('time', '>=', 'DATE_SUB(CURDATE(), INTERVAL 30 DAY)')->count('*');

            $jailtime = intval((1200 + ($dmtimes * 600)) / 60);

            if($jailtime > 60)
            {
                $jailtime = 60;
            }

            $text = "Admin " . $me->name . " <b>jailed</b> player <b>" . User::getName($topicdata->user_id) . "</b> for <b>" . $jailtime . "</b> minutes, reason: <b>DM #2</b>";
            $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ". Ai primit jail pentru " . $jailtime . " minute in urma acesteia.";
            $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been jailed by " . $me->name . "[admin:" . $me->id . "] for " . $jailtime . " minutes, reason: DM #2.";

            email($topicdata->user_id, $email, '/complaint/view/' . $complaint);

            PostController::addPost($complaint, $text, me());
            punish_log($topicdata->user_id, $log);

            UserController::jail($topicdata->user_id, $me->id, $jailtime, "DM #2", 0, $complaint);

            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 1, 'responser' => $me->id]);
            Cache::forget('topicdata' . $complaint);

            session()->flash('This player has been jailed for ' . $jailtime . " minutes without licence suspended.");
            return redirect('/complaint/view/' . $complaint);
        }
        else if(isset($_POST['ban']))
        {
            if(empty($_POST['reason']))
            {
                session()->flash('error', "Completeaza campul 'reason'.");
                return redirect('/complaint/view/' . $complaint);
            }
            if(empty($_POST['time']))
            {
                session()->flash('error', "Completeaza campul 'time'.");
                return redirect('/complaint/view/' . $complaint);
            }

            $time = intval($_POST['time']);

            if(!is_int($time))
            {
                session()->flash('error', "Valoare invalida pentru campul 'time'.");
                return redirect('/complaint/view/' . $complaint);
            }

            if($time <= 0 || $time > 999)
            {
                session()->flash('error', "Au fost gasite valori invalide introduse in campul 'time'.");
                return redirect('/complaint/view/' . $complaint);
            }

            if($time == 999)
            {
                $text = "Admin " . $me->name . " <b>permanently banned</b> player <b>" . User::getName($topicdata->user_id) . "</b>, reason: <b>" . $_POST['reason'] . "</b>";
                $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been permanent banned by " . $me->name . "[admin:" . $me->id . "], reason: " . $_POST['reason'] . ".";
            }
            else
            {
                $text = "Admin " . $me->name . " <b>banned</b> player <b>" . User::getName($topicdata->user_id) . "</b> for <b>" . $time . "</b> days, reason: <b>" . $_POST['reason'] . "</b>";
                $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ". Ai primit ban pentru " . $time . " zile in urma acesteia.";
                $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been banned by " . $me->name . "[admin:" . $me->id . "] for " . $time . " days, reason: " . $_POST['reason'] . ".";

                email($topicdata->user_id, $email, '/complaint/view/' . $complaint);
            }

            PostController::addPost($complaint, $text, me());
            punish_log($topicdata->user_id, $log);

            UserController::ban($topicdata->user_id, $me->id, $_POST['reason'], $time, $complaint);

            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 1, 'responser' => $me->id]);
            Cache::forget('topicdata' . $complaint);

            session()->flash('This player has been banned.');
            return redirect('/complaint/view/' . $complaint);
        }
        else if(isset($_POST['owner']))
        {
            $request_object = (object) ['name' => 'AdmBot', 'id' => '0'];
            $me = me();

            $text = $me->name . " requested an admin 5+ to respond to this topic.";

            PostController::addPost($complaint, $text, $request_object);
            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 2]);

            Cache::forget('topicdata' . $complaint);

            session()->flash('success', "You moved this topic to 'Owner+'.");
            return redirect('/complaint/view/' . $complaint);
        }
        else if(isset($_POST['jail']))
        {
            $jailtime = intval($_POST['time']);
            $reason = $_POST['reason'];

            $text = "Admin " . $me->name . " <b>jailed</b> player <b>" . User::getName($topicdata->user_id) . "</b> for <b>" . $jailtime . "</b> minutes, reason: <b>". $reason ."</b>";
            $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ". Ai primit jail pentru " . $jailtime . " minute in urma acesteia.";
            $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been jailed by " . $me->name . "[admin:" . $me->id . "] for " . $jailtime . " minutes, reason: ". $reason . ".";

            email($topicdata->user_id, $email, '/complaint/view/' . $complaint);

            PostController::addPost($complaint, $text, me());
            punish_log($topicdata->user_id, $log);

            UserController::jail($topicdata->user_id, $me->id, $jailtime, $reason, 1, $complaint);

            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 1, 'responser' => $me->id]);
            Cache::forget('topicdata' . $complaint);

            session()->flash('This player has been jailed for ' . $jailtime . " minutes with licence suspended.");
            return redirect('/complaint/view/' . $complaint);
        }
        else if(isset($_POST['mute']))
        {
            $time = intval($_POST['time']);
            $reason = $_POST['reason'];

            $text = "Admin " . $me->name . " <b>muted</b> player <b>" . User::getName($topicdata->user_id) . "</b> for <b>" . $time . "</b> minutes, reason: <b>". $reason ."</b>";
            $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ". Ai primit mute pentru " . $time . " minute in urma acesteia.";
            $log = "AdmPanel: " . User::getName($topicdata->user_id) . "[user:" . $topicdata->user_id . "] has been muted by " . $me->name . "[admin:" . $me->id . "] for " . $time . " minutes, reason: ". $reason . ".";

            email($topicdata->user_id, $email, '/complaint/view/' . $complaint);

            PostController::addPost($complaint, $text, me());
            punish_log($topicdata->user_id, $log);

            UserController::mute($topicdata->user_id, $me->id, $time, $reason, $complaint);

            DB::table('panel_topics')->where('id', '=', $complaint)->update(['status' => 1, 'responser' => $me->id]);
            Cache::forget('topicdata' . $complaint);

            session()->flash('This player has been muted for ' . $time . " minutes.");
            return redirect('/complaint/view/' . $complaint);
        }

        session()->flash('error', 'Select an action first.');
        return redirect('/complaint/view' . $complaint);
    }
    public function giveFactionWarn($complaint)
    {
        $me = me();
        $topicdata = Cache::get('topicdata' . $complaint);

        if(!is_object($topicdata))
        {
            session()->flash('error', 'Something went wrong.');
            return redirect('/complaint/view/' . $complaint);
        }

        if(!is_object($me) || $me->user_grouprank < 6 || $me->user_group != $topicdata->faction)
        {
            session()->flash('error', 'Unathorized access.');
            return redirect('/');
        }

        if(isset($_POST['fw']) && $topicdata->faction != 0)
        {
            if(!isset($_POST['fw_reason']))
            {
                session()->flash('error', 'Completeaza campul "Reason".');
                return redirect('/complaint/view/' . $complaint);
            }

            $id = DB::table('faction_warns')->insertGetId(['user' => $topicdata->user_id, 'reason' => $_POST['fw_reason']]);
            DB::update(DB::raw("UPDATE users SET user_fw=user_fw+1 WHERE id=" . $topicdata->user_id));

            $text = '<b>Panel action: </b>' . $me->name . ' gave ' . User::getName($topicdata->user_id) . ' a faction warn.';

            PostController::addPost($complaint, $text, $me);

            cache()->forget('topicdata' . $complaint);
            cache()->forget('userdata' . $topicdata->user_id);
            session()->flash('success', 'User ' . $topicdata->user_id . ' received FW #' . $id . ': ' . $_POST['fw_reason']);

            return redirect('/complaint/view/' . $complaint);
        }

        session()->flash('error', 'Invalid request.');
        return redirect('/complaint/view/' . $complaint);
    }

    public function viewReasonchange($topic)
    {
        $topicData = Cache::remember('topicdata' . $topic, 60, function() use ($topic) {
            return DB::table('panel_topics')->where('id', '=', $topic)->get()->first();
        });

        if(!is_object($topicData))
        {
            session()->flash('error', 'Invalid topic data.');
            return redirect('/');
        }

        $userData = User::fetchUserData($topicData->user_id);

        return view('complaint.reasonchange')->with('user', $userData)->with('topicID', $topic);
    }

    public function processReasonchange($topic)
    {
        if($_POST['reason'] < 1 || $_POST['reason'] > 7)
        {
            session()->flash('error', 'Invalid reason.');
            return redirect('/complaint/view/' . $topic);
        }

        $me = me();

        DB::table('panel_topics')->where('id', '=', $topic)->update(['reason'=>$_POST['reason']]);

        $text = $me->name . " changed this complaint reason to: " . Complaint::$reason_text[$_POST['reason']];
        PostController::addPost($topic, $text, $me);

        Cache::forget('topicdata' . $topic);

        session()->flash('success', 'Complaint reason changed!');
        return redirect('/complaint/view/' . $topic);
    }
}

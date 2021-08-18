<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ServerController;
use App\Group;
use App\Header;
use DB;
use Cache;
use Auth;

class GroupController extends Controller
{
    public static function list()
    {
        Auth::check() ? $me = me() : $me = null;

    	$groupdata = Cache::remember('grouplist', 5, function() {
    		return DB::table('groups')->get();
    	});

    	return view('group.list', ['groupdata' => $groupdata, 'me' => me()]);
    }
    public static function members($group)
    {
    	$value = DB::table('f_members')->where('faction', '=', $group)->join('users', 'users.id', '=', 'f_members.user')->select(array(DB::raw("TIMESTAMPDIFF(DAY, f_members.joined, NOW()) AS days"), 'f_members.*', 'users.id', 'users.name', 'users.user_groupskin', 'users.last_login'))->get();

        foreach($value as $v)
        {
            $v->raport_process = self::raport_process_date($v->process_date);
        }

        $goals = DB::table('f_goals')->where('group_id', '=', $group)->get();
        $points = DB::table('f_stats')->where('group_id', '=', $group)->get();

    	return view('group.members')->with('group', $group)->with('grouptype', Group::getGroupType($group))->with('data', $value)->with('goals', $goals)->with('points', $points);
    }
    public function logs($group)
    {
        $groupname = Group::getGroupName($group);

        $value = DB::table('flogs')->where('faction', '=', $group)->paginate(50);

        return view('group.logs', ['data' => $value, 'group' => $group, 'groupname' => $groupname]);
    }
    public function raport($group)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $groupdata = Group::getGroupData($group);

        if(!is_object($groupdata))
        {
            session()->flash('error', 'Something went wrong, try again.');
            return redirect('/admin');
        }

        $goals = Cache::remember('goals' . $group, 30, function() use ($group) {
            return DB::table('f_goals')->where('group_id', '=', $group)->get();
        });

        return view('group.raport')->with('name', $groupdata->group_name)->with('grouptype', $groupdata->group_type)->with('group', $group)->with('grouptypename', Group::$groupTypeName[$groupdata->group_type - 1])->with('goals', $goals);
    }
    public function raportEdit($group, $rank)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $goals = Cache::remember('goals' . $group, 30, function() use ($group) {
            return DB::table('f_goals')->where('group_id', '=', $group)->get();
        });

        return view('group.raportedit')->with('group', $group)->with('rank', $rank)->with('goals', $goals);
    }
    public function myraport()
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_group == 0)
        {
            session()->flash('error', 'Invalid group data.');
            return redirect('/');
        }


        $goals = Cache::remember('goals' . $me->user_group, 30, function() use ($me) {
            return DB::table('f_goals')->where('group_id', '=', $me->user_group)->get();
        });

        if($goals->isEmpty())
        {
            session()->flash('error', 'Invalid group data (f_goals).');
            return redirect('/');
        }

        $points = DB::table('f_stats')->where('user_id', '=', $me->id)->orderBy('type', 'asc')->get();

        $f_stats = Cache::remember('faction_stats' . $me->id, 10, function() use ($me) {
            return DB::table('f_members')->where('user', '=', $me->id)->limit(1)->get()->first();
        });

        if(!is_object($f_stats))
        {
            session()->flash('error', 'Invalid group data (f_stats).');
            return redirect('/');
        }


        return view('group.myraport')->with('goals', $goals)->with('points', $points)->with('f_stats', $f_stats)->with('me', $me)->with('process_date', self::raport_process_date($f_stats->process_date))->with('rankup_date', self::raport_process_date($f_stats->rankup_date));
    }

    public static function raport_process_date($unix)
    {
        $date = date('d.m.Y', $unix);

        if($date == date('d.m.Y', strtotime('today')))
        {
            $process_date = "astazi la ora 20:00";
        }
        else if($date == date('d.m.Y', strtotime('tomorrow')))
        {
            $process_date = "maine la ora 20:00";
        }
        else
        {
            $process_date = "pe " . $date . ", 20:00";
        }

        return $process_date;
    }

    public function migrate_raport()
    {
        $groups = Group::all();

        foreach($groups as $g)
        {
            DB::table('f_goals')->insert([['group_id' => $g->group_id, 'type' => 0, 'goal' => 5, 'rank' => 0]]);
        }

        session()->flash('success', 'Group goal (hours) has been added. Delete this route now.');
        return redirect('/');
    }
    /*
    public function migrate_raport()
    {
        DB::table('f_members')->where('user', '=', 2)->update(['process_date' => strtotime('+2 days')]);

        return redirect('/');
    }*/

    public function goalEdit($goal)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $goals = DB::table('f_goals')->where('id', '=', $goal)->get()->first();

        return view('group.goaledit')->with('goals', $goals)->with('goal', $goal);
    }
    public function goalDelete($goal)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $goals = DB::table('f_goals')->where('id', '=', $goal)->get()->first();

        DB::table('f_goals')->where('id', '=', $goal)->delete();

        Cache::forget('goals' . $goals->group_id);

        session()->flash('success', 'Goal deleted.');
        return redirect('/raport/' . $goals->group_id);
    }
    public function goalAdd($group, $rank)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $amount = intval($_POST['amount']);

        if(!is_int($amount))
        {
            session()->flash('error', 'Invalid amount.');
            return redirect('/raport/' . $group);
        }

        DB::table('f_goals')->insert([['type' => $_POST['goaltype'], 'goal' => $amount, 'group_id' => $group, 'rank' => $rank]]);

        Cache::forget('goals' . $group);

        session()->flash('success', 'Goal added!');
        return redirect('/raport/edit/' . $group . '/' . $rank);
    }
    public function goalEditPost($goal, $group)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $amount = intval($_POST['amount']);

        if(!is_int($amount))
        {
            session()->flash('error', 'Invalid amount.');
            return redirect('/raport/' . $group);
        }

        DB::table('f_goals')->where('id', '=', $goal)->update(['goal' => $amount]);

        Cache::forget('goals' . $group);

        session()->flash('success', 'Goal edited.');
        return redirect('/raport/' . $group);
    }
    public function raportHours()
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin < 6)
        {
            session()->flash('error', 'Unauthorized access (admin 6).');
            return redirect('/');
        }

        $amount = intval($_POST['hours']);

        if(!is_int($amount))
        {
            session()->flash('error', 'Only numeric values are accepted.');
            return redirect('/admin');
        }

        DB::table('f_goals')->where('type', '=', 0)->update(['goal' => $amount*3600]);

        for($i = 0; $i < Header::countHeaderFactions(); $i++)
        {
            Cache::forget('goals' . $i);
        }

        session()->flash('success', 'Numarul minim de ore a fost modificat (acum este nevoie de ' . $amount . ' ore la raportul de activitate).');
        return redirect('/admin');
    }
    public function appStatus($group)
    {
        $me = me();
        $data = Group::getGroupData($group);

        if($me->user_admin < 5 && ($me->user_group != $group || $me->user_grouprank < 6))
        {
            session()->flash('error', 'Unauthorized access.');
            return redirect('/');
        }

        if($data->group_application == 1)
        {
            session()->flash('success', 'Applications closed.');
            DB::table('groups')->where('group_id', '=', $group)->update(['group_application' => 0]);
        }
        else
        {
            session()->flash('success', 'Applications opened.');
            DB::table('groups')->where('group_id', '=', $group)->update(['group_application' => 1]);
        }

        Cache::forget('groupdata'.$group);

        return redirect('/group/list');
    }
    public function leader()
    {
        $me = me();

        if($me->user_grouprank < 6)
        {
            session()->flash('error', 'Unauthorized access.');
            return redirect('/');
        }

        $data = Group::getGroupData($me->user_group);

        $app = DB::table('panel_applications')->where('faction', '=', $me->user_group)->where('status', '=', 0)->count();
        $complaints = DB::table('panel_topics')->where('type', '=', 1)->where('status', '=', 0)->where('faction', '=', $me->user_group)->count();

        return view('group.leader')->with('data', $data)->with('me', $me)->with('applications', $app)->with('complaints', $complaints);
    }
    public function complaints($group)
    {
        $data = Cache::remember('faction_complaints' . $group, 5, function() use ($group) {
            return DB::table('panel_topics')->where('type', '=', 1)->where('faction', '=', $group)->join('users', 'panel_topics.user_id', '=', 'users.id')->select('panel_topics.id', 'panel_topics.creator_name', 'panel_topics.reason', 'panel_topics.time', 'panel_topics.status', 'users.name', 'users.user_group')->orderBy('id', 'desc')->paginate(30);
        });

        return view('group.complaints')->with('data', $data);
    }
    public function viewApplications($group)
    {
        $data = Cache::remember('applications' . $group, 2, function() use ($group) {
            return DB::table('panel_applications')->where('faction', '=', $group)->join('users', 'panel_applications.creator', '=', 'users.id')->select('panel_applications.*', 'users.name')->orderBy('id', 'desc')->limit(200)->get();
        });
        return view('group.applications')->with('groupname', Group::getGroupName($group))->with('data', $data);
    }

}

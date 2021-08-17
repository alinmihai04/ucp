<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clan;
use App\Http\Controllers\ServerController;
use Cache;
use DB;
use Auth;

class ClanController extends Controller
{
    public function list()
    {
    	$data = Cache::remember('clanlist', 10, function(){
    		return DB::table('clans')->select('id', 'clan_name', 'clan_tag', 'clan_slots', 'clan_members')->paginate(30);
    	});

    	return view('clan.list', ['data' => $data, 'me' => me()]);
    }
    public function view($clan)
    {
    	$data = Clan::getClanData($clan);

        if($data->isEmpty())
        {
            session()->flash('error', 'Invalid clan ID.');
            return redirect('/');
        }

    	$members = Cache::remember('clanmembers'.$clan, 10, function() use ($clan) {
    		return DB::table('c_members')->where('clan', '=', $clan)->join('users', 'c_members.id', '=', 'users.id')->select(array(DB::raw("TIMESTAMPDIFF(DAY, c_members.joined, NOW()) AS days"), 'c_members.*', 'users.name', 'users.user_clanrank'))->orderBy('users.user_clanrank', 'desc')->get();
    	});
    	$logs = Cache::remember('clanlogs'.$clan, 10, function() use ($clan) {
    		return DB::table('clan_logs')->where('clanid', '=', $clan)->limit(20)->get();
    	});


    	return view('clan.view')->with('data', $data->first())->with('members', $members)->with('logs', $logs)->with('auth', Auth::check())->with('me', me());
    }
    public function register()
    {
        return view('clan.register')->with('me', me());
    }
    public function registerPost()
    {
        if(empty($_POST['name']) || empty($_POST['tag']))
        {
            session()->flash('error', 'Completeaza toate campurile.');
            return redirect('/clan/register');
        }
        if(strlen($_POST['name']) > 32)
        {
            session()->flash('error', 'Numele clanului este prea lung, poti avea un nume format din maxim 32 de caractere.');
            return redirect('/clan/register');            
        }
        if(strlen($_POST['tag']) > 6 || strlen($_POST['tag']) < 3)
        {
            session()->flash('error', 'Tag-ul clanului este prea scurt / lung, poti avea un tag format din minim 3 caractere si maxim 6 caractere.');
            return redirect('/clan/register');            
        }        

        $validate = DB::table('clans')->where('clan_name', '=', $_POST['name'])->orWhere('clan_tag', '=', $_POST['tag'])->count();

        if($validate > 0)
        {
            session()->flash('error', 'Numele / Tag-ul ales de tine apartine deja altui clan.');
            return redirect('/clan/register');
        }

        $me = me();

        if($me->user_clanrank == 7)
        {
            session()->flash('error', 'Deja detii un clan. Sterge / transfera clanul curent pentru a putea crea alt clan.');
            return redirect('/clan/register');           
        }
        if($me->user_premiumpoints < 100)
        {
            session()->flash('info', 'Ai nevoie de 100 puncte premium pentru a inregistra un clan.');
            return redirect('/clan/register');
        }

        $id = DB::table('clans')->insertGetId(['clan_name' => $_POST['name'], 'clan_tag' => $_POST['tag'], 'clan_expire' => strtotime('+3 months')]);
        DB::table('panel_actions')->insert([['action_id' => 3, 'user_id' => $me->id, 'action_time' => $id]]);

        DB::statement('UPDATE users SET `user_clan`=' . $id . ', `user_clanrank`=7, `user_premiumpoints`=`user_premiumpoints`-100 WHERE `id`=' . $me->id);

        if($me->user_clan > 0)
        {
            DB::table('c_members')->where('id', '=', $me->id)->delete();
        }

        DB::table('c_members')->insert([['clan' => $id, 'id' => $me->id, 'rank' => 7]]);

        Cache::forget('userdata' . $me->id);
        Cache::forget('clanlist');

        $log = "Player " . $me->name . "[user:" . $me->id . "] created a clan for 100 premium points, name: " . $_POST['name'] . ", tag: " . $_POST['tag'];

        important_log($me->id, 0, $log, 'clan');

        session()->flash('success', 'Clanul tau a fost creat (-100 puncte premium).');
        return redirect('/profile/' . $me->name);
    }
    public function delete($clan)
    {
        $me = me();

        if($me->user_admin < 5 && $me->user_support < 2 && ($me->user_clanrank < 7 || $me->user_clan != $clan))
        {
            session()->flash('error', 'Unauthorized access.');
            return redirect('/');
        }        

        $validate = Clan::getClanData($clan)->first();

        if(!is_object($validate))
        {
            session()->flash('error', 'Clanul pe care incerci sa il stergi nu exista. Pentru a sterge un clan, intra pe pagina acestuia si apasa pe butonul "Delete Clan", nu accesa acest link direct din bara de adrese.');
            return redirect('/clan');
        }

        DB::table('clans')->where('id', '=', $clan)->delete();
        DB::table('c_members')->where('id', '=', $clan)->delete();
        DB::table('users')->where('user_clan', '=', $clan)->update(['user_clan' => 0, 'user_clanrank' => 0]);

        if($me->user_admin > 0)
        {
            $log = "Admin " . $me->name . "[admin:" . $me->id . "] has deleted clan with ID " . $clan . " (" . $validate->clan_name . ", " . $validate->clan_tag . ").";
            $text = "AdmPanel: Admin " . $me->name . " deleted clan with ID " . $clan . " (" . $validate->clan_name . ", " . $validate->clan_tag . ").";

            admin_log($me->id, 0, $log, 'clan delete');
        }
        else
        {
            $log = "Clan owner " . $me->name . "[user:" . $me->id . "] has deleted clan with ID " . $clan . " (" . $validate->clan_name . ", " . $validate->clan_tag . ").";
            $text = "AdmPanel: Clan owner " . $me->name . " deleted clan with ID " . $clan . " (" . $validate->clan_name . ", " . $validate->clan_tag . ").";

            important_log($me->id, 0, $log, 'clan delete');
        }

        ServerController::sendPanelAction(0, 4, 0, $clan, $text);

        Cache::forget('clanlist');
        Cache::forget('clandata' . $clan);

        session()->flash('success', 'Clan deleted!');
        return redirect('/');
    }
    public function edit($clan)
    {
        if(!Auth::check())
        {
            session()->flash('error', 'You need to login first.');
            return redirect('/login');
        }

        $me = me();

        if($me->user_admin == 0 && ($me->user_clan != $clan || $me->user_clanrank < 7))
        {
            session()->flash('error', 'Unauthorized access.');
            return redirect('/');
        }

        if($me->user_admin > 0)
        {
            $_POST['text'] = $_POST['text'] . "<br><br><b>Edited by Admin " . $me->name . ", " . date('j M', time()) . "</b>";
        }

        DB::table('clans')->where('id', '=', $clan)->update(['clan_desc' => $_POST['text']]);
        Cache::forget('clandata' . $clan);

        session()->flash('success', 'Clan description edited!');
        return redirect('/clan/view/' . $clan);
    }
}

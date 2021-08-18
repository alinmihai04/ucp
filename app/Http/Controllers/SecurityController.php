<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use DB;
use Auth;
use URL;
use Hash;


class SecurityController extends Controller
{
    public function enable2fa()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $_POST['verify-code'];

        $valid = $google2fa->verifyKey(session('google2fa_secret'), $secret);
        if($valid)
        {
        	DB::table('users')->where('id', '=', Auth::id())->update(['user_2fa' => 1, 'user_2fakey' => session('google2fa_secret')]);

        	session()->flash('success', 'Ai activat cu success autentificarea in 2 pasi.');
        	session()->forget('google2fa_secret');

        	Cache::forget('userdata' . Auth::id());
            return redirect('/');
        }
        else
        {
        	session()->flash('error', 'Invalid application code. Please try again.');
            return redirect('/account/security/code/');
        }
    }
    public function validateCode()
    {
        $google2fa = app('pragmarx.google2fa');
        $secret = $_POST['2fa_code'];

        $valid = $google2fa->verifyKey(me()->user_2fakey, $secret);
        if($valid)
        {
        	session()->flash('success', 'Code accepted!');
        	session()->put('google2fa_passed', 1);
        	session()->remove('force_2fa');

            return redirect(URL::previous());
        }
        else
        {
        	session()->flash('error', 'Invalid application code. Please try again.');
            return redirect('/');
        }
    }
    public function view2fa()
    {
        $me = me();

        if($me->name == "Alin" || $me->name == "helper" || $me->name == "leader" || $me->name == "player")
        {
            session()->flash('error', "(Demo) You can't activate 'Two Factor Auth' on this account.");
            return redirect('/');
        }

        return view('auth.twofactor')->with('userdata', $me);
    }
    public function process2fa()
    {
        $me = me();

        if($me->user_2fa == 1)
        {
            session()->flash('error', 'Ai activat deja autentificarea in 2 pasi.');
            return redirect('/');
        }

        $google2fa = app('pragmarx.google2fa');

        if(session('google2fa_secret'))
        {
        	$google2fa_secret = session('google2fa_secret');
        }
        else
        {
	        $google2fa_secret = $google2fa->generateSecretKey();
	        session()->put('google2fa_secret', $google2fa_secret);
        }

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.title'),
            $me->name,
            $google2fa_secret
        );

        return view('auth.twofactor2')->with('QR_Image', $QR_Image)->with('secret', $google2fa_secret);
    }

    public function disable2fa()
    {
        $me = me();

        if($me->user_2fa == 0)
        {
            session()->flash('error', "Nu ai autentificarea in 2 factori activa.");
            return redirect('/account/security');
        }

        if(!Hash::check($_POST['password'], $me->password))
        {
            session()->flash('error', "Parola introdusa nu este aceeasi cu parola contului.");
            return redirect('/account/security');
        }
        else
        {
            session()->remove('google2fa_passed');

            DB::table('users')->where('id','=', $me->id)->update(['user_2fa' => 0, 'user_2fakey' => 'disabled']);
            Cache::delete('userdata' . $me->id);

            session()->flash('success', "Autentificarea in 2 pasi a fost dezactivata cu succes.");
            return redirect('/account/security');
        }
    }
}

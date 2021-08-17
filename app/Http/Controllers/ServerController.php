<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ServerController extends Controller
{
    public static function sendPanelAction($user, $action, $time, $value, $text)
    {
    	DB::table('panel_actions')->insert([['user_id' => $user, 'action_id' => $action, 'action_time' => $time, 'action_value' => $value, 'action_text' => $text]]);
    }
}

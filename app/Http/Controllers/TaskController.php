<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ServerController;

class TaskController extends Controller
{
    public function test()
    {
    	ServerController::sendPanelAction(0, 5, 0, 0, "Merge baaa.");
    }   
}

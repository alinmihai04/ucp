<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
	public function mapPage($x, $y)
	{
		return view('main.map')->with('x', $x)->with('y', $y);
	}
    public function renderMap($x, $y)
    {
    	$img = imagecreatefromjpeg(public_path() . '/images/map.jpg');
    	$red = imagecolorallocate($img, 255, 0, 0);

    	$x = $x/7.6;
    	$y = $y/7.6;

    	$x = $x + 400;
    	$y = -($y - 400);

    	if($x + 5 > 800)
    	{
    		$x -= 5;
    	}

    	imagefilledrectangle($img, $x, $y, $x+10, $y+10, $red);

    	header('Content-Type: image/jpeg');
    	$image = imagejpeg($img);
    	imagedestroy($img);
    }
}

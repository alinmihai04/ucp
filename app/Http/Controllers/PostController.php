<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Cache;
use DB;
use Auth;

class PostController extends Controller
{
    public function add($topic)
    {
    	if(!Auth::check())
    	{
    		return redirect('/login');
    	}

    	$me = me();
    	$topicdata = Cache::get('topicdata' . $topic);

    	if(!is_object($topicdata))
    	{
    		session()->flash('error', 'Invalid topic data.');
    		return redirect('/');
    	}

    	switch($topicdata->type)
    	{
    		case 1:
    		{
    			$redirect = 'complaint';
    			break;
    		}
    		case 2:
    		{
    			$redirect = 'ticket';
    			break;
    		}
    		case 3:
    		{
    			$redirect = 'unban';
    		}
    		default:
    		{
    			return redirect('/');
    		}
    	}

    	if($me->user_admin > 0)
    	{
    		$action = 'Admin action: ';
    	}
    	else if($topicdata->faction > 0 && $me->user_grouprank >= 6 && $me->user_group == $topicdata->faction)
    	{
    		$action = 'Faction manager action: ';
    	}

    	if(isset($_POST['postclose']))
    	{
    		if(($me->user_group != $topicdata->faction || $me->user_grouprank < 6) && $me->user_admin == 0)
			{
				session()->flash('error', 'Unauthorized access.');
				return redirect('/');
			}

			if($topicdata->status == 0 && !empty($_POST['reply']))
			{
	    		DB::table('panel_topics')->where('id', '=', $topic)->update(['status' => 1]);

	    		$text = $_POST['reply'] . '<br><b>' . $action . '</b> Topic closed.';

	    		self::addPost($topic, $text, me());

                $email = "Reclamatia creata de " . User::getName($topicdata->creator_id) . " a fost inchisa de adminul " . $me->name . ".";

                email($topicdata->user_id, $email, '/complaint/view/' . $topic);

	    		Cache::forget('topicposts' . $topic);
	    		Cache::forget('topicdata' . $topic);

	    		session()->flash('success', 'This topic has been closed.');
	    		return redirect('/' . $redirect . '/view/' . $topic);
			}
			else if($topicdata->status == 1)
			{
	    		DB::table('panel_topics')->where('id', '=', $topic)->update(['status' => 0]);

	    		$text = $_POST['reply'] . '<br><b>' . $action . '</b> Topic re-opened.';

	    		self::addPost($topic, $text, me());

	    		Cache::forget('topicposts' . $topic);
	    		Cache::forget('topicdata' . $topic);

	    		session()->flash('success', 'This topic has been re-opened.');
	    		return redirect('/' . $redirect . '/view/' . $topic);
			}
    	}

    	if(isset($_POST['delete']))
    	{
    		if($me->user_admin < 3)
    		{
    			session()->flash('error', 'Unauthorized access.');
    			return redirect('/');
    		}

    		if($topicdata->status != 3)
    		{
	     		DB::table('panel_topics')->where('id', '=', $topic)->update(['status' => 3]);

                if(!empty($_POST['reply']))
                {
                   $text = $_POST['reply'] . '<br><b>' . $action . '</b> Topic deleted!';
                }
	    		else
                {
                    $text = '<br><b>' . $action . '</b> Topic deleted!';
                }

	    		self::addPost($topic, $text, me());

	    		Cache::forget('topicposts' . $topic);
	    		Cache::forget('topicdata' . $topic);

	    		return redirect('/' . $redirect . '/view/' . $topic);
    		}
    		else
    		{
	     		DB::table('panel_topics')->where('id', '=', $topic)->update(['status' => 1]);

                if(!empty($_POST['reply']))
                {
                   $text = $_POST['reply'] . '<br><b>' . $action . '</b> Topic un-deleted and closed!';
                }
                else
                {
                    $text = '<br><b>' . $action . '</b> Topic un-deleted and closed!';
                }

	    		self::addPost($topic, $text, me());

	    		Cache::forget('topicposts' . $topic);
	    		Cache::forget('topicdata' . $topic);

	    		session()->flash('error', 'This topic is no longer deleted.');
	    		return redirect('/' . $redirect . '/view/' . $topic);
    		}
    	}

    	if(empty($_POST['reply']))
    	{
    		session()->flash('error', 'You can not post an empty comment.');
    		return redirect('/' . $redirect . '/view/' . $topic);
    	}
    	if($topicdata->status != 0 && $me->user_admin == 0)
    	{
     		session()->flash('error', 'You cannot post a comment in a closed topic.');
    		return redirect('/');
    	}

        $delay = time() - session('post_delay');

        if($delay < 120)
        {
            session()->flash('error', 'Poti posta un comentariu o data la 2 minute. Mai poti posta un comentariu peste ' . (120 - $delay). ' secunde.');
            return redirect('/' . $redirect . '/view/' . $topic);
        }

    	DB::table('panel_posts')->insert([['user_id' => $me->id, 'user_name' => $me->name, 'text' => $_POST['reply'], 'topic' => $topic]]);
    	Cache::forget('topicposts' . $topic);

        if($topicdata->type == 1 && $me->user_admin >= 1)
        {
            email($topicdata->user_id, "Reclamatia creata impotriva ta de catre " . $topicdata->creator_name . " a primit unul sau mai multe raspunsuri de la un admin.", "/complaint/view/" . $topic);
            email($topicdata->creator_id, "Reclamatia creata impotriva lui " . $topicdata->user_name . " a primit unul sau mai multe raspunsuri de la un admin.", "/complaint/view/" . $topic);
        }

        session()->put('post_delay', time());
    	session()->flash('success', 'Comment posted!');
    	return redirect('/' . $redirect . '/view/' . $topic);
    }

    public static function addPost($topic, $text, $request_object)
    {
    	DB::table('panel_posts')->insert([['user_id' => $request_object->id, 'user_name' => $request_object->name, 'text' => $text, 'topic' => $topic]]);

    	Cache::forget('topicposts' . $topic);
    }

    public function delete($post)
    {
    	$me = me();

    	if($me->user_admin < 3)
    	{
    		session()->flash('error', 'Unauthorized access.');
    		return redirect('/');
    	}

    	$data = DB::table('panel_posts')->where('id', '=', $post)->get()->first();

    	if(!is_object($data))
    	{
    		session()->flash('error', 'Invalid post data.');
    		return redirect('/');
    	}

    	if($data->hidden == 0)
    	{
    		DB::table('panel_posts')->where('id', '=', $post)->update(['hidden' => 1]);

    		session()->flash('success', 'Comment: "' . $data->text . '" is now hidden.');
    	}
    	else
    	{
			DB::table('panel_posts')->where('id', '=', $post)->update(['hidden' => 0]);

			session()->flash('success', 'Comment: "' . $data->text . '" is no longer hidden.');
    	}

    	Cache::forget('topicposts' . $data->topic);

    	return redirect('/complaint/view/' . $data->topic);
    }
}

<?php

class Home_Controller extends Base_Controller {

	public function action_index() {

		$threads = Thread::order_by('sticky', 'desc')->order_by('updated_at', 'desc')->take(Config::get('ezrahub.num_homepage_threads'))->get();
		Section::inject('title', 'a forum for Cornell University students');
		Section::inject('description', 'Ezra Hub is a popular and student-run forum for Cornell University students. Anonymous posting and user accounts are allowed and everything from frats, sororities, classes, drugs, housing and more is discussed. Ezra Hub is not endorsed by Cornell University.');
		if (empty($threads)) {
			$this->layout->nest('content', 'home.nothreadsyet');
		} else {
			$this->layout->nest('content', 'home.index', array('threads' => $threads));
		}
	}

    public function action_scroll() {

        $iteration = (int) Input::get('iteration');
        $new_threads = Thread::order_by('updated_at', 'desc')->skip(Config::get('ezrahub.num_homepage_threads') + 15 * $iteration)->take(15)->get();
        return Response::json(array('threads_html' => View::make('home.threads', array('threads' => $new_threads))->render()));
    }

	public function action_update() {

        $latest_id = Input::get('latest_id');
        $new_threads = Thread::where('id', '>', $latest_id)->order_by('updated_at', 'desc')->get();

        if (!empty($new_threads)) {
        	return Response::json(array('update' => '1', 'threads_html' => View::make('home.threads', array('threads' => $new_threads))->render()));
        } else {
        	return Response::json(array('update' => '0'));
        }

    }

    public function action_online_users() {
        return View::make('home.onlineusers');
    }

	public function action_rules() {
		Section::inject('title', 'Forum rules' );
		Section::inject('description', 'Ezra Hub has some simple to follow rules, find out what they are to avoid being banned.');
		$this->layout->nest('content', 'home.rules');
	}

	public function action_about() {
		Section::inject('title', 'About us and our history' );
		Section::inject('description', 'Find out about the history of Ezra Hub, from our birth as Cornell Hub, to our history with the administration and more!');
		$this->layout->nest('content', 'home.about');
	}

	public function action_banned()
	{
		if (Auth::check() && Auth::user()->banned) {
			$ban = Auth::user()->bans_to()->order_by('expires_at', 'desc')->first();
			$this->layout->nest('content', 'error.banned', array('ban' => $ban));
		}// elseif (IPBanUtil::banned(Request::ip)) {
    //     $ban = IPBanUtil::getBan(Request::ip);
    // }
		elseif (!isset($ban)) {
    		header("Location: {$_SERVER['HTTP_HOST']}");
    	}
	}

}
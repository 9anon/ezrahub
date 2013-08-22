<?php

class Thread_Controller extends Base_Controller {

    public function action_index($id, $slug='') {
        $thread = Thread::find($id);
        if ($thread != null) {

            if (Auth::check()) { //we're logged in, add a thread view event
                $thread->mark_as_read(Auth::user()->id);
            }

            //separate the OP and reply posts (this is a little hackish)
            $posts = $thread->posts()->order_by('created_at', 'asc')->get();
            $op = array_shift($posts);

            Section::inject('title', '#' . $thread->id . ' - ' . $thread->title );
            Section::inject('description', substr(strip_tags($op->body), 0, 155) . '...');
            Section::inject('canonical', '<link rel="canonical" href="http://ezrahub.com/thread/' . $thread->id . '/' . $thread->slug . '"/>');
            //return the view
            $this->layout->nest('content', 'thread.thread', array('thread' => $thread, 'op' => $op, 'posts' => $posts));
        } else {
            $this->layout->nest('content', 'error.thread404');
        }
    }

    public function action_new() {
        return View::make('thread.new');
    }

    public function action_new_post() {

        //collect the data from the form
        $input = Input::get();

        //get the id of the user, or determine it's a coward
        $user_id = Auth::get_anon_or_user_id();

        //has the user requested to be anonymous?
        if (isset($input['becomeanon'])) {
            $user_id = 0;
        }

        //validate the input
        if (!Auth::check()) {
            $rules = array(
                'title' => 'required|between:' . Config::get('ezrahub.min_thread_title_length') . ',' . Config::get('ezrahub.max_thread_title_length'),
                'post-body' => 'required|between:' . Config::get('ezrahub.min_thread_length') . ',' . Config::get('ezrahub.max_thread_length'),
                'date'        => 'honeypot',
                'date_time'   => 'required|honeytime:' . Config::get('ezrahub.honeytime'),
                //make anonymous cowards do the recaptcha
                'recaptcha_response_field' => 'required|recaptcha:' . Config::get('ezrahub.recaptcha_private_key'),
                //make anonymous cowards verify they are not a robot
                'robot' => 'required'
            );
        } else {
            $rules = array(
                'title' => 'required|between:' . Config::get('ezrahub.min_thread_title_length') . ',' . Config::get('ezrahub.max_thread_title_length'),
                'post-body' => 'required|between:' . Config::get('ezrahub.min_thread_length') . ',' . Config::get('ezrahub.max_thread_length'),
                'date'        => 'honeypot',
                'date_time'   => 'required|honeytime:' . Config::get('ezrahub.honeytime')
            );
        }
        $messages = array(
            'title_required' => 'You must type out a title for this thread.',
            'title_between' => 'The title of your thread must be between :min and :max characters.',
            'post-body_required' => 'You can\'t submit an empty thread. Please type out something for the post body!',
            'post-body_between' => 'The body of your post must be between :min and :max characters. You have written ' . strlen($input['post-body']) . ' characters.',
            'recaptcha_response_field_required' => 'You must fill out the captcha correctly.',
            'robot_required' => 'You must verify that you are not a robot'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {

            //create a new thread object
            $new_thread = new Thread(array(
                'title' => $input['title'],
                'user_id' => $user_id,
                'poster_ip' => Request::ip()
            ));

            //create a new post object
            $new_post = new Post(array(
                'body' => $input['post-body'],
                'poster_ip' => Request::ip(),
                'user_id' => $user_id
            ));

            //save both the post and the thread in the database
            $user = User::find($user_id);
            $thread = $user->threads()->insert($new_thread);
            $thread->posts()->insert($new_post);

            //redirect to the new thread
            return Response::json(array('new_thread_url' => $thread->id . '/' . $thread->slug));
        }
    }

    public function action_delete($id) {
        //find which thread we are manipulating
        $thread = Thread::find($id);

        if (!$thread) {
            //that thread doesn't exist
            return Response::json(array('success' => '0'));
        }

        //delete all the posts in the thread
        Post::where("thread_id", '=', $id)->delete();

        //then delete the thread itself
        $thread->delete();

        return Response::json(array('success' => '1'));
    }

    public function action_sticky($id) {
        //find which thread we are manipulating
        $thread = Thread::find($id);

        //check to make sure this thread exists
        if (!$thread) {
            return Response::json(array('success' => '0'));
        }

        //sticky or un-sticky it
        $thread->toggle_sticky();

        return Response::json(array('success' => '1'));
    }

    //tiggle the lock bit
    public function action_lock($id) {
        //find which thread we are manipulating
        $thread = Thread::find($id);

        //check to make sure this thread exists
        if (!$thread) {
            return Response::json(array('success' => '0'));
        }

        //lock or unlock it
        $thread->toggle_lock();

        return Response::json(array('success' => '1'));
    }

    public function action_bumplock($id) {
        //find which thread we are manipulating
        $thread = Thread::find($id);

        //check to make sure this thread exists
        if (!$thread) {
            return Response::json(array('success' => '0'));
        }

        //bumplock or un-bumplock the thread
        $thread->toggle_bumplock();

        return Response::json(array('success' => '1'));

    }

    public function action_update($id) {

        //find the thread we're updating
        $thread = Thread::find($id);

        //get the input from the poll request
        $input = Input::get();

        //get the variables we need, DON'T forget to JSON decode or it will throw an error
        $inserted_posts = json_decode($input['inserted_posts']);
        $latest_id = $input['latest_id'];

        //decide what to do depending on if there are inserted posts via the form
        if (empty($inserted_posts)) {
            //just do a simple query, don't have to worry about inserted posts
            $new_posts = $thread->posts()->where('id', '>', $latest_id)->order_by('created_at', 'asc')->get();
        } else {
            //get the threads that are new but not inserted by the user via the form
            $new_posts = $thread->posts()->where('id', '>', $latest_id)->where_not_in('id', $inserted_posts)->order_by('created_at', 'asc')->get();
        }

        if (Auth::check()) {
            //we've read the thread once more via automatic updating, so mark it as read
            $thread->mark_as_read(Auth::user()->id);
        }

        //determine if there is anything new
        if (!empty($new_posts)) {
            //there were new posts in the database, return the html for them to append
            return Response::json(array('update' => '1', 'replies_html' => View::make('thread.replies', array('posts' => $new_posts))->render()));
        } else {
            //there were no new posts
            return Response::json(array('update' => '0'));
        }
    }

    public function action_read_all($page_number) {
        $user_id = Auth::user()->id;
        foreach (Thread::all() as $thread) {
            $thread->mark_as_read($user_id);
        }
        return Response::json(array('success' => '1'));
    }

    public function action_random() {
        $thread = DB::first(
            'SELECT r1.id
              FROM threads AS r1 JOIN
                   (SELECT (RAND() *
                                 (SELECT MAX(id)
                                    FROM threads)) AS id)
                    AS r2
             WHERE r1.id >= r2.id
             ORDER BY r1.id ASC
             LIMIT 1'
        );
        return Redirect::to('thread/' . $thread->id);
    }
}

?>

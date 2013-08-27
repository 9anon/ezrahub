<?php

class User_Controller extends Base_Controller {

    public function action_index($username) {
        if ($username == 'me') {
            if (Auth::check()) {
                //we use the own-profile shortcut
                $user = Auth::user();
            } else {
                return Redirect::to('/');
            }
        } else {
            //we have defined a user that is not ourself
            $user = User::where('name', '=', $username)->first();
        }

        //make sure the user exists
        if (!$user) {
            return Redirect::to('/');
        }

        //get the user's latest posts
        $last_posts = $user->posts()->order_by('created_at', 'desc')->take(Config::get('ezrahub.profile_num_recent_posts'))->get();
        $last_reps = $user->reps_to()->order_by('created_at', 'desc')->take(Config::get('ezrahub.profile_num_recent_reps'))->get();
        Section::inject('title', $user->name . '\'s profile');
        Section::inject('description', $user->name . '\'s profile on Ezra Hub.' . ' Bio: ' . $user->bio . ' Join date: ' . date('F j, Y', strtotime($user->created_at)));
        if (Auth::check() && Auth::user()->id == $user->id) {
            //we are logged in and it's our own profile
            $messages = Message::where('user_to', '=', Auth::user()->id)->order_by('created_at', 'desc')->take(Config::get('ezrahub.profile_num_messages'))->get();
            $sent_messages = Message::where('user_from', '=', Auth::user()->id)->take(Config::get('ezrahub.profile_num_sent_messages'))->get();
            $this->layout->nest('content', 'user.profile', array('user' => $user, 'last_posts' => $last_posts, 'messages' => $messages, 'sent_messages' => $sent_messages, 'last_reps' => $last_reps));
        } else {
            //it's not our own profile
            $this->layout->nest('content', 'user.profile', array('user' => $user, 'last_posts' => $last_posts, 'last_reps' => $last_reps));
        }
    }

    public function action_new_post() {
        //collect the input
        $input = Input::get();

        //validation
        $rules = array(
            'name' => 'required|alpha_dash|between:' . Config::get('ezrahub.min_username_length') . ',' . Config::get('ezrahub.max_username_length') . '|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:' . Config::get('ezrahub.min_password_length')
        );
        $messages = array(
            'name_between' => 'Your username must be at least :min and no more than :max characters.',
            'name_unique' => 'That username is already in use.',
            'email_required' => 'You must enter an email address.',
            'email' => 'That doesn\'t look like a valid email address.',
            'email_unique' => 'Someone is already using that email address.',
            'password_required' => 'You must choose a password',
            'password_min' => 'Your password must be at least :min characters.'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {
            //we can make a new user!
            $user = User::create(array(
                'email' => $input['email'],
                'name' => $input['name'],
                'password' => $input['password'],
                'reputation' => Config::get('ezrahub.default_rep'),
                'bio' => 'I\'m a little tea pot, short and stout. Here is my handle, here is my spout.',
                'ip' => Request::ip(),
                'last_seen' => date('Y-m-d H:i:s')
            ));
            //log the user in
            Auth::login($user->id);
            //return the welcome message, as well as the username
            return Response::json(array('welcome_message' => '<p class="welcome-message">Welcome to <span class="ezra-hub">ezra hub</span>!</p><div class="welcome-user-info">' . Avatar::generate('medium', $user) . '<span class="username">' . $user->name . '</span>' . Reputation::generate($user) . '<span class="welcome-messages"><span class="icon-envelope-alt"></span>' . $user->messages_to()->where('read', '=', 0)->count() . ' new</span><div class="clear both"></div><p>Why not spiff up your profile a little bit?</p></div>', 'username' => $user->name));

            //send an email to the user's email? to do later
        }
    }

    public function action_forgot_password() {
        $this->layout->nest('content', 'user.forgotpw');
    }

    public function action_login() {
        return View::make('user.login');
    }

    public function action_login_post() {

        //collect the input
        $input = Input::get();

        //put together our credentials to attempt logging in
        $credentials﻿ = array(
            'username' => $input['username'],
            'password' => $input['password'],
            'remember' => !empty($input['rememberme']) ? true: false
        );

        //attempt logging in
        if (Auth::attempt($credentials﻿)) {
            $user = Auth::user();
            $user->ip = Request::ip();
            $user->last_seen = date('Y-m-d H:i:s');
            $user->active = 1;
            $user->save();
            //return the welcome message
            return Response::json(array('welcome_message' => '<p class="welcome-message">Welcome back to <span class="ezra-hub">ezra hub</span>, brah!</p><div class="welcome-user-info">' . Avatar::generate('medium', $user) . '<span class="username">' . $user->name . '</span>' . Reputation::generate($user) . '<span class="welcome-messages"><span class="icon-envelope-alt"></span>' . $user->messages_to()->where('read', '=', 0)->count() . ' new</span><div class="clear both"></div></div>'));
        } else {
            return Response::json(array('errors' => 'I\'m sorry Dave, I\'m afraid I can\'t do that.'));
        }
    }

    public function action_is_active() {

    }

    public function action_edit_avatar() {
        return View::make('user.editavatarform');
    }

    public function action_edit_avatar_post() {

        //get the file upload
        $image = Input::file('image');

        //validation
        $rules = array(
            'image' => 'image|max:1000|mimes:jpg,png,gif'
        );
        $messages = array(
            'image' => 'That doesn\'t look like an image.',
            'max' => 'The maximum file size is :max KB.',
            'mimes' => 'You may upload a .jpg, .png or .gif image.'
        );
        $validation = Validator::make($image, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {

            //find out what user is uploading an image
            $user_id = Auth::user()->id;

            //resize to the three required thumbnails
            $large = Resizer::open($image)->resize(250, 250, 'crop')->save('public/img/avatars/' . $user_id . '_l.jpg', 60);
            $medium = Resizer::open($image)->resize(45, 45, 'crop')->save('public/img/avatars/' . $user_id . '_m.jpg', 60);
            $small = Resizer::open($image)->resize(12, 12, 'crop')->save('public/img/avatars/' . $user_id . '_s.jpg', 60);

            //check to see if they all worked
            if ($large && $medium && $small) {
                return Response::json(array('success' => '1'));
            } else {
                exit;
            }
        }
    }

    public function action_edit_bio() {

        //get the input
        $input = Input::get();

        return View::make('user.editbioform', array('previous' => $input['previous']));
    }

    public function action_edit_bio_post() {

        //get the input from the form
        $input = Input::get();

        //validation
        $rules = array(
            'bio' => 'required|max:250'
        );
        $messages = array(
            'required' => 'You must type something.',
            'max' => 'Your bio can only be 250 characters or less.'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {
            //find out what user is updating their bio
            $user_id = Auth::user()->id;

            //update the bio
            $affected = DB::table('users')->where('id', '=', $user_id)->update(array('bio' => $input['bio']));

            //retrieve the new bio stored in the db
            $new_bio = DB::table('users')->where('id', '=', $user_id)->only('bio');

            //return the JSON success response with the new bio
            return Response::json(array('success' => '1', 'new_bio' => $new_bio));
        }
    }

    public function action_edit_email() {
         //get the input from the form
        $input = Input::get();

        //validation
        $rules = array(
            'email' => 'required|email|unique:users'
        );
        $messages = array(
            'email_required' => 'You must enter an email address.',
            'email' => 'That doesn\'t look like a valid email address.',
            'email_unique' => 'Someone is already using that email address.'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {
            //find out what user is updating their email
            $user_id = Auth::user()->id;

            //update the bio
            $affected = DB::table('users')->where('id', '=', $user_id)->update(array('email' => $input['email']));

            //return the JSON success response
            return Response::json(array('success' => '1'));
        }
    }

    public function action_edit_password() {
        //get the input from the form
        $input = Input::get();

        //validation
        $rules = array(
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password'
        );
        $messages = array(
            'password_required' => 'You must choose a password',
            'min' => 'Your password must be at least :min characters.',
            'password_confirm_required' => 'You must confirm your password',
            'password_confirm_same' => 'Try confirming your password again, those two didn\'t match!'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {
            //find out what user is updating their password
            $user_id = Auth::user()->id;

            //update the bio
            $affected = DB::table('users')->where('id', '=', $user_id)->update(array('password' => Hash::make($input['password'])));

            //return the JSON success response
            return Response::json(array('success' => '1'));
        }
    }

    public function action_delete_avatar() {

        //find out what user is removing their avatar
        $user_id = Auth::user()->id;

        // delete all three thumbnails
        File::delete('public/img/avatars/' . $user_id . '_l.jpg');
        File::delete('public/img/avatars/' . $user_id . '_m.jpg');
        File::delete('public/img/avatars/' . $user_id . '_s.jpg');

        return Response::json(array('success' => '1'));
    }

    public function action_send_message($to_id) {
        //get the id of the user sending the message
        $from_id = Auth::user()->id;

        //make sure the user we're sending this to exists
        $user_check = User::where('id', '=', $to_id)->first();
        if (!$user_check) {
            return Response::json(array('success' => '0'));
        }

        //collect the data from the form
        $input = Input::get();

        //validate the input
        $rules = array(
            'post-body' => 'required|between:' . Config::get('ezrahub.min_post_length') . ',' . Config::get('ezrahub.max_post_length')
        );
        $messages = array(
            'post-body_required' => 'You can\'t submit an empty reply. Please type out something for the post body!',
            'post-body_between' => 'The body of your message must be between :min and :max characters. You have written ' . strlen($input['post-body']) . ' characters.'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json($validation->errors);
        } else {

            //create a new message object and save it in the DB
            $new_message = new Message(array(
                'user_from' => $from_id,
                'user_to' => $to_id,
                'poster_ip' => Request::ip(),
                'message' => $input['post-body']
            ));
            $new_message->save();

            //return the response
            return Response::json(array('success' => '1'));
        }
    }

    public function action_read_message($message_id) {

        $message = Message::find($message_id);
        $message->mark_as_read();
        return View::make('user.profile.viewmessage', array('message' => $message));

    }

    public function action_logout() {

        //update so they are no longer active
        $user = User::find(Auth::user()->id);
        $user->active = 0;
        $user->save();

        //log the user out and kick them to the homepage
        Auth::logout();
        return Redirect::to('/');
    }
}

?>

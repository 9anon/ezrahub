<?php

class Post_Controller extends Base_Controller {

    public function action_index() {
        //nothing to see here
    }

    public function action_new_post($thread_id) {

        //get the id of the user, or determine it's a coward
        $user_id = Auth::get_anon_or_user_id();

        //find out which thread we are replying to
        $thread = Thread::find($thread_id);
        if ($thread == null || $thread->lock) {
            //this thread does not exist or we cannot reply to it
            return false;
        }

        //collect the data from the form
        $input = Input::get();

        //validate the input
        if (!Auth::check()) {
            $rules = array(
                'post-body' => 'required|between:' . Config::get('ezrahub.min_post_length') . ',' . Config::get('ezrahub.max_post_length'),
                'date'        => 'honeypot',
                'date_time'   => 'required|honeytime:' . Config::get('ezrahub.honeytime'),
                //make anonymous cowards do the reCAPTCHA
                'recaptcha_response_field' => 'required|recaptcha:' . Config::get('ezrahub.recaptcha_private_key')
            );
        } else {
            $rules = array(
                'post-body' => 'required|between:' . Config::get('ezrahub.min_post_length') . ',' . Config::get('ezrahub.max_post_length'),
                'date'        => 'honeypot',
                'date_time'   => 'required|honeytime:' . Config::get('ezrahub.honeytime')
            );
        }

        $messages = array(
            'post-body_required' => 'You can\'t submit an empty reply. Please type out something for the post body!',
            'post-body_between' => 'The body of your post must be between :min and :max characters. You have written ' . strlen($input['post-body']) . ' characters.',
            'honeytime' => 'Try to slow down a little bit there, captain. You\'re posting too fast.',
            'honeypot' => 'What the hell are you doing?',
            'date_time_required' => 'What the hell are you doing?',
            'recaptcha_response_field_required' => 'You must submit the captcha.',
            'recaptcha_response_field_recaptcha' => 'Your captcha was incorrect.'
        );
        $validation = Validator::make($input, $rules, $messages);

        if ($validation->fails()) {
            return Response::json(array('success' => '0', 'messages' => $validation->errors));
        } else {

            //create a new post object
            $new_post = new Post(array(
                'body' => $input['post-body'],
                'poster_ip' => Request::ip(),
                'user_id' => $user_id
            ));

            //save the post in the database
            $thread->posts()->insert($new_post);

            if (!isset($input['nobump']) && !$thread->bumplock) {
                //bump the thread
                $thread->touch();
            }

            //fix the retarded laravel datetime bug, fuck you laravel
            //https://github.com/laravel/laravel/issues/1259
            $new_post->created_at = $new_post->created_at->format('Y-m-d H:i:s');

            if (Auth::check()) { //we're logged in, add a thread view event
                $thread->mark_as_read(Auth::user()->id);
            }

            //return the response (some hacky shit to make the posts array like from a thread model)
            return Response::json(array('success' => '1', 'inserted_id' => $new_post->id, 'new_post' => View::make('thread.replies', array('posts' => array($new_post->id => $new_post)))->render()));
        }
    }

    public function action_quote($post_id) {

        //get the post we want to retrieve the content of
        $post = Post::find($post_id);

        //find out who made that post
        $poster_name = $post->user->name;

        //strip any other quotes out of there so we don't get double quotes
        $body_without_quotes = preg_replace('/\[quote=\"([^\"]+)\"\](.*?)\[\/quote\]/is', '', $post->body_raw);
        //strip out quotes if they aren't to a user, as well
        $body_without_quotes = preg_replace('/\[quote\](.*?)\[\/quote\]/is', '', $body_without_quotes);
        //strip out images
        $body_without_quotes = preg_replace('/\[img\](.*?)\[\/img\]/is', '', $body_without_quotes);

        //return the content
        return Response::json(array('content' => '[quote="' . $poster_name . '"]' . trim($body_without_quotes) . '[/quote]'));
    }

    public function action_edit_form($post_id) {

        //get the post we want to retrieve the content of
        $post = Post::find($post_id);

        //return the editing view with the edit form
        return View::make('thread.editpost', array('post' => $post));

    }

    public function action_edit($post_id) {

        //find the post we are referencing
        $post = Post::find($post_id);

        //make sure we are allowed to edit it (owner, mod, admin)
        if (Auth::check() && Auth::user()->id == $post->user->id || Auth::check() && Auth::user()->has_role('admin') || Auth::check() && Auth::user()->has_role('mod')) {

            //get the new content
            $input = Input::get();

            //validate the input
            $rules = array(
                'edited-body' => 'required|between:' . Config::get('ezrahub.min_post_length') . ',' . Config::get('ezrahub.max_post_length')
            );
            $messages = array(
                'edited-body_required' => 'You can\'t submit an empty reply. Please type out something for the post body!',
                'edited-body_between' => 'The body of your post must be between :min and :max characters. You have written ' . strlen($input['edited-body']) . ' characters.'
            );
            $validation = Validator::make($input, $rules, $messages);

            if ($validation->fails()) {
                return Response::json($validation->errors);
            } else {

                //find out who edited it
                $editor = Auth::user()->name;

                //update the model and save it with edited info
                $post->body = $input['edited-body'];
                $post->edited_by = $editor;
                $post->save();

                //return success and the new html for the post
                return Response::json(array('success' => '1', 'new_post_body' => $post->body));
            }
        } else {
            //we are not allowed to delete this, return failure
            return Response::json(array('success' => '0'));
        }
    }

    public function action_delete($post_id) {

        //find the post we are referencing
        $post = Post::find($post_id);

        //make sure we are allowed to delete it (owner, mod, admin)
        if (Auth::check() && Auth::user()->id == $post->user->id || Auth::check() && Auth::user()->has_role('admin') || Auth::check() && Auth::user()->has_role('mod')) {
            //delete the post from the database
            $post->delete();

            //return success
            return Response::json(array('success' => '1'));
        } else {
            //we are not allowed to delete this, return failure
            return Response::json(array('success' => '0'));
        }

    }
}

?>

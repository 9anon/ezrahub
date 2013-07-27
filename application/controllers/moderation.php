<?php

class Moderation_Controller extends Base_Controller {
    public function action_ban_user($id) {
        $user_to = User::find($id);
        if (!$user_to && !$user_to->has_role('admin')) {
            return Redirect::back(); //has to be a valid user and we can't ban admins
        }
        $this->layout->nest('content', 'mod.ban-user', array('user_to' => $user_to));
    }

    public function action_ban_user_post($id) {
        $user_to = User::find($id);
        if (!$user_to && !$user_to->has_role('admin')) {
            return Redirect::back(); //has to be a valid user and we can't ban admins
        }

        $rules = array(
                'ban-reason' => 'required',
                'expiration-date' => 'match:/\d+-\d+-\d+ \d+:\d+/'
            );
        $validation = Validator::make(Input::get(), $rules);

        if ($validation->fails()) {
            return Redirect::back()->with_errors($validation)->with_input();
        }

        $ban = new Ban(array(
                            'message' => Input::get('ban-reason'),
                            'user_from' => Auth::user()->id,
                            'expires_at' => Input::get('expiration-date') //will put in model later
                       ));

        $user_to->bans_to()->insert($ban);
        return Redirect::to('/');
    }
}

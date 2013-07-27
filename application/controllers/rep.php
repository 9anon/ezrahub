<?php

class Rep_Controller extends Base_Controller {

    public function action_index($id) {

        // get the user we are going to rep or neg
        $user = User::find($id);

        //make sure this user exists
        if (!$user) {
            return Response::json(array('success' => '0'));
        }

        return View::make('user.repform', array('user' => $user));
    }

    //figure out the sign of the rep action, +1 () or -1 (neg)
    public function action_up($id) {
        return $this->rep($id, 1);
    }

    public function action_down($id) {
        return $this->rep($id, -1);
    }

    /* Returns a JSON response with the amount and success indicator,
    and reps according to the following rules:
     (1)
    */
    private function rep($id, $sign) {

        //make sure we are logged in
        if (!Auth::check()) {
            return Response::json(array('success' => '0', 'reason' => 'You must be logged in to do that.'));
        }

        //collect everything we need
        $from_user = Auth::user();
        $to_user = User::find($id);
        $comment = Input::get('comment');

        //make errors array
        $errors = array();

        //user to give the rep to doesn't exist
        if (!$to_user) {
            array_push($errors, 'That user doesn\'t exist... what the fuck are you doing?');
        }

        //can't rep yourself
        if ($from_user->id == $to_user->id) {
            array_push($errors, 'Sorry, you can\'t rep yourself.');
        }

        //must include a comment
        if ($comment == '') {
            array_push($errors, 'You must include a comment.');
        }

        //must have at least 5 rep to rep someone else
        if ($from_user->reputation < Config::get('ezrahub.rep_threshold')) {
            array_push($errors, '<b>Sorry, but you need at least ' . Config::get('ezrahub.rep_threshold') . ' reputation to rep or neg.</b>');
        }

        //can only rep a certain # of times per day
        if ($from_user->reps_from()->where('created_at', '>', date('Y-m-d H:i:s', time() - Config::get('ezrahub.rep_same_user')))->count() >= Config::get('ezrahub.rep_per_day')) {
            array_push($errors, 'You have already repped or negged ' . Config::get('ezrahub.rep_per_day') . ' times in the past 24 hours.');
        }

        //can only rep the same person once per day
        if ($from_user->reps_from()->where('user_to', '=', $to_user->id)->where('created_at', '>', date('Y-m-d H:i:s', time() - Config::get('ezrahub.rep_same_user')))->count() > 0) {
            array_push($errors, 'Try spreading some rep around elsewhere before giving it to ' . $to_user->name . ' again today.');
        }

        if (!empty($errors)) {
            //there were errors, return them
            return Response::json(array('success' => '0', 'messages' => $errors));
        } else {
            //calculate the rep power
            $rep_power = (int) $from_user->reputation_raw / 100;

            //create a new rep object
            $rep = new Rep(array(
                'user_to' => $to_user->id,
                'rep_amount' => $rep_power,
                'comment' => $comment,
                'sign' => $sign
            ));

            //insert in the database
            $from_user->reps_from()->insert($rep);

            //now apply the rep to the receiving user
            $to_user->reputation = $to_user->reputation_raw + $sign * $rep_power;
            $to_user->save();

            return Response::json(array('success' => '1', 'amount' => $sign * $rep_power));
        }
    }
}

?>

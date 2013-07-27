<?php

//written by will najar for ezra hub
//will.najar@gmail.com
//shh no tears... only dreams now

class Reputation {
    static function generate($user) {

        //make sure we got the right parameters
        if (empty($user)) {
            return "You must pass the user you wish you print out reputation for.";
        }

        if ($user->id == 0) {
            //anonymous coward doesn't show reputation
            return '';
        }

        //find out if this user is a red or a green and give them an icon
        //icons using font-awesome http://fortawesome.github.io/Font-Awesome/icons/
        if ($user->reputation >= 10000) {
            $class = 'very positive';
            $icon = 'trophy';
            $title = $user->name . ' is on top of the world! Click to rep/neg them.';
        } elseif ($user->reputation >= 5000) {
            $class = 'very positive';
            $icon = 'star';
            $title = $user->name . ' is one of the best hubizens. Click to rep/neg them.';
        } elseif ($user->reputation >= 1000) {
            $class = 'very positive';
            $icon = 'ok-sign';
            $title = $user->name . ' is a great hubizen! Click to rep/neg them.';
        } elseif ($user->reputation >= 1) {
            //he's a green
            $class = 'positive';
            $icon = 'plus-sign';
            $title = $user->name . ' is a good hubizen. Click to rep/neg them.';
        } elseif($user->reputation <= -1) {
            //he's a red
            $class = 'negative';
            $icon = 'minus-sign';
            $title = $user->name . ' is a fratstar. Click to rep/neg them.';
        } else {
            //he has no rep yet, or has rep of 0
            $class = 'neutral';
            $icon = 'question-sign';
            $title = $user->name . ' hasn\'t tested the waters yet. Click to rep/neg them.';
        }

        if ($user->reputation >= 1000) {
            //we have a special user here!
            $rep_string = '<span class="reputation ' . $class .  '" title="' . $title .'" data-user-id="' . $user->id .'"><span class="rep-icon icon-' . $icon . '"></span>' . abs(floor((float)$user->reputation_raw * 10 / 100000) / 10) . 'k</span>';
        } else {
            //format the html
            $rep_string = '<span class="reputation ' . $class .  '" title="' . $title .'" data-user-id="' . $user->id .'"><span class="rep-icon icon-' . $icon . '"></span>' . number_format(abs($user->reputation)) . '</span>';
        }

        return $rep_string;
    }
}

?>

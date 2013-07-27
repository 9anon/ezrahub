<?php

//written by will najar for ezra hub
//will.najar@gmail.com
//shh no tears... only dreams now

class Avatar {
    static function generate($format, $user) {

        $dimensions = array(
            //these are square dimensions so we only need to provide one
            'large' => '250',
            'medium' => '45',
            'small' => '12'
        );

        $suffixes = array(
            //these are the suffixes that correspond to image filenames
            'large' => 'l',
            'medium' => 'm',
            'small' => 's'
        );

        //make sure we got the right parameters
        if (empty($format) || empty($user)) {
            return "You must provide an avatar format and you must pass the user you want an avatar for.";
        } else if (!array_key_exists($format, $dimensions)) {
            //this is not a valid dimension
            return "You have not specified a valid dimension";
        }

        $id = $user->id;
        $name = $user->name;
        $extra_class = '';
        //special anon coward exception
        if ($user->id == 0) {
            $extra_class = ' anon-coward';
        }

        //check if the user has uploaded an avatar yet
        if (file_exists('/var/www/public/img/avatars/' . $id . '_m.jpg')) {
            //they have, proceed as normal
            $image_source = '/img/avatars/' . $id . '_' . $suffixes[$format]  . '.jpg';
        } else {
            //they haven't
            $image_source = '/img/avatars/default_' . $suffixes[$format] . '.jpg';
        }


        //format the html
        $avatar_string = '<img class="avatar ' . $format . $extra_class .  '" src="' . $image_source . '" width="' . $dimensions[$format] . '" height="' . $dimensions[$format] . '" alt="' . $name . '">';

        return $avatar_string;
    }
}

?>

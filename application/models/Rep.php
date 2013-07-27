<?php

class Rep extends Eloquent {

    public static $timestamps = true;

    //setters
    public function change_reputation($rep) {
        //logic to determine how reputation changes
    }

    //relationships
    public function from_user() {
        return $this->belongs_to('User', 'user_from');
    }
    public function to_user() {
        return $this->belongs_to('User', 'user_to');
    }
}

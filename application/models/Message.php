<?php

class Message extends Eloquent {

    public static $timestamps = true;

    public function mark_as_read() {
        $this->set_attribute('read', 1);
        $this->save();
    }

    //setters
    public function set_message($message) {
        $this->set_attribute('message', trim($message));
    }

    //relationships
    public function from_user() {
        return $this->belongs_to('User', 'user_from');
    }
    public function to_user() {
        return $this->belongs_to('User', 'user_to');
    }
}

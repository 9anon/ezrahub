<?php

class Post extends Eloquent {

    public static $timestamps = true;

    //setters
    public function set_poster_ip($ip) {
        $this->set_attribute('poster_ip', ip2long($ip));
    }

    public function set_body($body) {
        $this->set_attribute('body', strip_tags(trim($body)));
    }

    //getters
    public function get_poster_ip() {
        return long2ip($this->get_attribute('poster_ip'));
    }

    public function get_body() {
        // process BBCode in post body when we read it
        return BBCode::parse($this->get_attribute('body'));
    }

    //returns raw body text for updates and edits
    public function get_body_raw() {
        return $this->get_attribute('body');
    }

    //relationships
    public function user(){
        return $this->belongs_to('User');
    }

    public function thread(){
        return $this->belongs_to('Thread');
    }

    public function likes() {
        return $this->has_many('Like');
    }
}

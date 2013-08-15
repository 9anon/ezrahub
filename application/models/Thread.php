<?php
class Thread extends Eloquent {
    public static $timestamps = true;

    public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug'
    );

    //setters
    public function set_poster_ip($ip) {
        $this->set_attribute('poster_ip', ip2long($ip));
    }

    public function set_title($title) {
        $this->set_attribute('title', strip_tags(trim($title)));
    }

    //getters
    public function get_poster_ip() {
        return long2ip($this->get_attribute('poster_ip'));
    }

    //sticky a thread
    public function toggle_sticky() {
        if (!$this->sticky) {
            //the thread isn't stickied, sticky it
            $this->set_attribute('sticky', 1);
        } else {
            //the thread is stickied, unsticky it
            $this->set_attribute('sticky', 0);
        }
        $this->save();
    }

    //lock a thread
    public function toggle_lock() {
        if (!$this->lock) {
            //the thread isn't bumplocked, bumplock it
            $this->set_attribute('lock', 1);
        } else {
            //the thread is bumplocked, unbumplock it
            $this->set_attribute('lock', 0);
        }
        $this->save();
    }

    //bumplock a thread
    public function toggle_bumplock() {
        if (!$this->bumplock) {
            //the thread isn't bumplocked, bumplock it
            $this->set_attribute('bumplock', 1);
        } else {
            //the thread is bumplocked, unbumplock it
            $this->set_attribute('bumplock', 0);
        }
        $this->save();
    }

    //mark a thread as read
    public function mark_as_read($user_id) {
        if ($threadview = ThreadView::where_user_id_and_thread_id($user_id, $this->id)->first()) {
            //we have one, just update it
            $threadview->touch();
        } else{
            //we don't haev one, make one
            $threadview = new ThreadView(array(
                                            'user_id' =>  $user_id,
                                            'thread_id' => $this->id
                                         ));
            $threadview->save();
        }
    }

    //relationships
    public function user(){
        return $this->belongs_to('User');
    }

    public function posts() {
        return $this->has_many('Post');
    }

    public function threadviews() {
        return $this->has_many('ThreadView');
    }

}

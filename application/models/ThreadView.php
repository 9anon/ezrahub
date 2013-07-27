<?php

class ThreadView extends Eloquent {

    public static $timestamps = true;

    //relationships
    public function user(){
        return $this->belongs_to('User');
    }

    public function thread(){
        return $this->belongs_to('Thread');
    }

}

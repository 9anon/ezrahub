<?php

class Ban extends Eloquent {

    public static $timestamps = true;

    //relationships
    public function ban_from() {
        return $this->has_many('User', 'user_from');
    }

    public function ban_to() {
        return $this->has_many('User', 'user_to');
    }
}

<?php
class User extends Eloquent {

    public static $timestamps = true;
    //setters
    public function set_password($password) {
        $this->set_attribute('password', Hash::make($password));
    }

    public function set_ip($ip) {
        $this->set_attribute('last_login_ip', ip2long($ip));
    }

    //getters
    public function get_ip() {
        return long2ip($this->get_attribute('last_login_ip'));
    }

    public function get_reputation() {
        return floor((int) $this->get_attribute('reputation') / 100);
    }

    public function get_reputation_raw() {
        return $this->get_attribute('reputation');
    }

    public function get_banned() {
        return ($this->bans_to()->where('expires_at', '>', DB::raw('NOW()'))->count() > 0);
    }

    //relationships
    public function posts() {
        return $this->has_many('Post');
    }

    public function threads() {
        return $this->has_many('Thread');
    }

    public function likes() {
        return $this->has_many('Like');
    }

    public function reps_from() {
        return $this->has_many('Rep', 'user_from');
    }

    public function reps_to() {
        return $this->has_many('Rep', 'user_to');
    }

    public function messages_from() {
        return $this->has_many('Message', 'user_from');
    }

    public function messages_to() {
        return $this->has_many('Message', 'user_to');
    }

    public function bans_from() {
        return $this->has_many('Ban', 'user_from');
    }

    public function bans_to() {
        return $this->has_many('Ban', 'user_to');
    }

    //authority acl functions
    public function roles()
    {
        return $this->has_many_and_belongs_to('Role', 'role_user');
    }

    public function has_role($key)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $key)
            {
                return true;
            }
        }

        return false;
    }

    public function has_any_role($keys)
    {
        if( ! is_array($keys))
        {
            $keys = func_get_args();
        }

        foreach($this->roles as $role)
        {
            if(in_array($role->name, $keys))
            {
                return true;
            }
        }

        return false;
    }

}

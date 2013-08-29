<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Site-wide Config
    |--------------------------------------------------------------------------
    |
    | Variables that affect display and meta-information site-wide.
    |
    */

    'version_number' => '0.9.2b',
    'admin_email' => 'admin@ezrahub.com',


    /*
    |--------------------------------------------------------------------------
    | Homepage Variables
    |--------------------------------------------------------------------------
    |
    | Variables that control the display and workings of the homepage.
    |
    */

    'num_homepage_threads'   => 25,


    /*
    |--------------------------------------------------------------------------
    | Posting Settings
    |--------------------------------------------------------------------------
    |
    | Variables that control posting new threads/replies and post content.
    |
    */

    //Thread/post constraints
    'min_thread_title_length' => 10, /* in characters */
    'max_thread_title_length' => 180,
    'min_thread_length' => 10,
    'max_thread_length' => 15000,
    'min_post_length' => 2, /* also applies for messages */
    'max_post_length' => 10000,

    //Spam protection
    'honeytime' => 3, /* the min time in seconds a user must wait before submitting thread/post */
    'recaptcha_private_key' => '6Lc_teISAAAAAH8klIZchhygfovnVoth6gxhxY27', /* get from https://www.google.com/recaptcha/ and don't forget to also update the public key in main.js! */


    /*
    |--------------------------------------------------------------------------
    | User Settings
    |--------------------------------------------------------------------------
    |
    | Various variables related to the inner workings of the rep system, like
    | thresholds and "magic" constants.
    |
    */

    //Settings for new user creation
    'min_username_length' => 4, /* in characters */
    'max_username_length' => 20,
    'min_password_length' => 6,

    //Variables for display of user profiles
    'profile_num_recent_posts' => 5,
    'profile_num_recent_reps' => 20,
    'profile_num_messages' => 20,
    'profile_num_sent_messages' => 20,


    /*
    |--------------------------------------------------------------------------
    | Rep Variables
    |--------------------------------------------------------------------------
    |
    | Various variables related to the inner workings of the rep system, like
    | thresholds and "magic" constants.
    |
    */

    'rep_threshold' => 1,
    'rep_per_day' => 10,
    'rep_same_user' => 60*60*24,
    'rep_proportion' => 0.095,
    'default_rep' => 0

);

?>

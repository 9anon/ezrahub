## [Ezra Hub](http://ezrahub.com) - a forum for Cornell University students.

Ezra Hub is a clean, modern, Ajax-enabled and feature-rich forum that builds upon the mistakes of past forum software and does things the right way. Ezra hub is built from the ground up on top of the [Laravel 3](http://laravel.com) framework and is maintained by a small group of Cornell University students/alums.

Ezra Hub's main implementation is on [ezrahub.com](http://ezrahub.com) and is catered towards Cornell University students.

### Feature Overview

- Infinite-scrolling threads view on homepage
- Anonymous posting w/ restrictions
- Optional user accounts w/ extra features
- Option for logged-in users to post anonymously
- Robust reputation system
- User-to-user Messaging
- Fully Ajax-enabled and near real-time
- Spam-beating features for anonymous posters
- Post-quoting
- Ezra-Hub-flavored BBcode post formatting
- Stickying threads
- Locking threads
- Bumplocking threads
- Banning users and IP addresses
- User profile pages
- Thread and post search
- Real-time post and thread statistics + SMOG index rating

### Current Version and Status
The current version of Ezra Hub is 0.9b. Ezra Hub is currently a BETA release. We acknowledge that not everything fully works, and there may be bugs.

### How to Install
First, install a base version of [Laravel 3](http://laravel.com) (** NOT ** version 4!) on your server and configure it to connect successfully with the MySQL database of your choosing, and to use `mod_rewrite` for URL rewriting. Documentation to set up Laravel 3 can be found at [http://three.laravel.com/docs](http://three.laravel.com/docs).

Next, install the following Laravel bundles via the `artisan` command-line tool:
- authority
- honeypot
- resizer
- sluggable
- recaptcha

Consulting `/application/bundles.php` for reference if needed (where each bundle is registered).

Then, copy the files in this repository over your Laravel 3 install directory, overwriting the files already there.

Lastly, import the `ezrahub.sql` SQL file in the root directory into the database you created in the first step, and Ezra Hub should be good to go!


### License

Ezra Hub is licensed under the GPLv2. See the included LICENSE file.

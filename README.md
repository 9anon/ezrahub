## [Ezra Hub](http://ezrahub.com) - a forum for Cornell University students.

Ezra Hub is a clean, modern, Ajax-enabled and feature-rich forum that builds upon the mistakes of past forum software and does things the right way. Ezra hub is built from the ground up on top of the [Laravel 3](http://laravel.com) framework and borrows nothing from other clunky forum software.

Ezra Hub's main implementation is on [ezrahub.com](http://ezrahub.com) and is catered towards Cornell University students.

### Feature Overview

- Infinite-scrolling threads on homepage
- Anonymous posting w/ restrictions
- Optional user accounts w/ extra features
- Robust reputation system
- Messaging
- Fully Ajax-enabled
- Spam-beating features for anonymous posters
- Post-quoting
- Stickying
- Locking
- Bumplocking
- Thread and post search

### Current Version and Status
The current version of Ezra Hub is 0.9b. Ezra Hub is currently a BETA release. We acknowledge that not everything fully works, and there may be bugs.

### How to Install
**Please note: we do not currently have an option to set up the necessary MySQL database table structure, which means users will be unable to replicate Ezra Hub at this time.** First, install a base version of [Laravel 3](http://laravel.com) (NOT version 4!) on your server and configure it to connect successfully with MySQL and to use `mod_rewrite`.

Install the bundles:
- authority
- honeypot
- resizer
- sluggable
- reaptcha

Then, copy over the files in this repository over your Laravel 3 install directory and reset Laravel's cache. Ezra Hub should be good to go!*


### License

Ezra Hub is licensed under the GPLv2. See the included LICENSE file.

## [Ezra Hub](http://ezrahub.com) - a forum for Cornell University students.
Ezra Hub is a clean, modern, Ajax-enabled and feature-rich forum that builds upon the mistakes of past forum software and does things the right way. Ezra hub is built from the ground up on top of the [Laravel 3](http://laravel.com) framework and is maintained by a small group of Cornell University students/alums.

Ezra Hub's main implementation is on [ezrahub.com](http://ezrahub.com) and is catered towards Cornell University students.

### Feature Overview
- Infinite-scrolling threads view on homepage
- Fully Ajax-enabled and near-real-time thread/index updating
- Configurable variables in an easy-to-edit configuration file
- Anonymous posting w/ restrictions
- User accounts w/ extra features and functionality
- Option for logged-in users to post anonymously
- Robust reputation system similar to that seen on the [bodybuilding.com forums](http://forum.bodybuilding.com/faq.php?faq=repuationsystem_faq)
- User-to-user private messaging
- Spam-beating features for anonymous posters
- Ezra-Hub-flavored [BBCode](http://en.wikipedia.org/wiki/BBCode) post markup
- Post-quoting
- Stickying threads
- Locking threads
- Bumplocking threads
- Banning users and IP addresses
- User profile pages
- Thread and post search
- Real-time post and thread statistics + [SMOG](http://en.wikipedia.org/wiki/SMOG) index rating

### Current Version and Status
The current version of Ezra Hub is 0.9b. Ezra Hub is currently a BETA release. We acknowledge that not everything fully works, and there may be bugs.

### How to Install
Ezra Hub is relatively simple to install for an administrator with average skills.

1. Clone the [Laravel 3](https://github.com/laravel/laravel/tree/v3.2.14) repository from GitHub onto your server and install/configure it so it is working. **Make sure not to install Laravel 4**, as it is not fully compatible. Excellent documentation to install/configure Laravel 3 can be found at [http://three.laravel.com/docs](http://three.laravel.com/docs). For the database setup, Ezra Hub is configured to use `MySQL`, so fill out that section in `application/config/database.php`. Follow the directions to configure your installation to use `mod_rewrite`, and and don't forget to make the appropriate changes in `application/config/application.php` which include setting the index option to an empty string.
2. Copy all of the files in this repository over your Laravel 3 install directory, overwriting the files already there.
3. Import the `ezrahub.sql` SQL dump using a tool like phpMyAdmin into the database you created in the first step, and all the tables will be created for you with the appropriate structure.
4. Navigate to your Ezra Hub install and sign up. **The first user you create will become the admin user**, as the SQL dump includes a row giving the user with ID = 1 an administrative role.
5. Start using Ezra Hub and let us know how it goes!

### License
Ezra Hub is licensed under the GPLv2. Laravel 3 is licensed under the Apache license. See the included LICENSE file.

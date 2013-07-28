## [Ezra Hub](http://ezrahub.com) - a forum for Cornell University students.
Ezra Hub is a clean, modern, Ajax-enabled and feature-rich forum that builds upon the mistakes of past forum software and does things the right way. Ezra hub is built from the ground up on top of the [Laravel 3](http://laravel.com) framework and is maintained by a small group of Cornell University students/alums.

Ezra Hub's main implementation is on [ezrahub.com](http://ezrahub.com) and is catered towards Cornell University students.

### Feature Overview
- Infinite-scrolling threads view on homepage
- Fully Ajax-enabled and near-real-time thread/index updating as well as thread/post submission
- Configurable variables in an easy-to-edit configuration file
- Anonymous posting w/ restrictions
- User accounts w/ extra features and functionality
- Option for logged-in users to post anonymously
- "Nope" feature to avoid bumping a thread
- Robust reputation system similar to that seen on the [bodybuilding.com forums](http://forum.bodybuilding.com/faq.php?faq=repuationsystem_faq)
- User-to-user private messaging
- Spam-protection features for anonymous posters
- Ezra-Hub-flavored [BBCode](http://en.wikipedia.org/wiki/BBCode) post markup
- Post-quoting
- Stickying threads
- Locking threads
- Bumplocking threads
- Banning users and IP addresses
- User profile pages
- User biographies and reputation history
- Thread and post search
- Real-time post and thread statistics + [SMOG](http://en.wikipedia.org/wiki/SMOG) index rating

### Requirements
Ezra Hub's requirements mirror the requirements of Laravel. To use Ezra Hub you will need:
- Apache
- MySQL
- PHP 5.3 or greater
- PHP FileInfo library (usually included with PHP 5.3 or greater)
- PHP MCrypt library (usually included with PHP 5.3 or greater)
- The ability to change your server's `DocumentRoot`
- Apache `mod_rewrite`

### Current Version and Status
The current version of Ezra Hub is 0.9b. Ezra Hub is currently a **BETA** release. We acknowledge that not everything fully works, and there may be bugs.

### How to Install
Ezra Hub is quick and simple to install for the average technically-oriented administrator. For non-technical users, your mileage may vary. Most of the difficulty comes in installing and configuring Laravel and not in setting up Ezra Hub.

1. Create a new table on your MySQL server and import the `ezrahub.sql` SQL dump (located in the root of this repo) into a MySQL database of your choosing.
2. Clone the [Laravel 3 branch from the Laravel repository on GitHub](https://github.com/laravel/laravel/tree/3.0) onto your server and carefully follow the documentation found at [http://three.laravel.com/docs](http://three.laravel.com/docs) to install/configure Laravel with the table you created in Step 1. Follow the optional documentation to configure your installation to use `mod_rewrite` and don't forget to make the appropriate changes in `application/config/application.php`.
3. Verify that your Laravel installation is working by navigating to your install in a web browser.
4. Clone this repository to a separate folder and then copy all of the files over your Laravel 3 install directory 1:1, overwriting the files already there.
5. Navigate to your Ezra Hub install in a web browserand sign up as a new user. **The first user you create will become the admin user**.

### Configuration
Simple, easy-to-edit configuration variables for Ezra Hub are located in `application/config/ezrahub.php`. If you want to configure anything else, you'll be editing code.

### License
Ezra Hub is licensed under the GPLv2. Laravel 3 is licensed under the Apache license. See the included LICENSE file.

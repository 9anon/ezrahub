<footer>
    <div class="footer-col main">
        <p><b>{{ number_format(Thread::count()) }}</b> threads, <b>{{ number_format(Post::count()) }}</b> posts, <b>{{ number_format(User::count()) }}</b> registered users. | &copy; 2011-2013 <span class="ezra-hub">Ezra Hub</span> v{{ Config::get('ezrahub.version_number') }} | <a target="_blank" href="https://github.com/wnajar/ezrahub"><span class="icon-github"></span> source</a> | <a href="mailto:{{ Config::get('ezrahub.admin_email') }}">{{ Config::get('ezrahub.admin_email') }}</a> | <span class="ezra-hub">Ezra Hub</span> is <strong>not</strong> endorsed by <a target="_blank" href="http://cornell.edu">Cornell University</a>.</p>
    </div>
</footer>

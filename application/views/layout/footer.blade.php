<footer>
    <div class="footer-col main">
        <div id="footer-stats">
            <h5 class="footer-lobster">fun facts and statistics:</h5>
            <p>There are <b>{{ number_format(Thread::count()) }}</b> threads, <b>{{ number_format(Post::count()) }}</b> posts and <b>{{ number_format(User::count()) }}</b> registered users on the forum. There are <a class="online-users" href="/users/online">{{ User::where('active', '=', '1')->count() }} users online right now</a>. Users have sent <b>{{ number_format(Message::count()) }}</b> private messages, the banhammer has been swung <b>{{ number_format(Ban::count()) }}</b> times and a total of <b>{{ number_format(Rep::sum('rep_amount') / 100) }}</b> reputation has been handed out by users.</p>
        </div>
        @yield('footercontent')
    </div>
    <div class="footer-col right">
        <h5 class="footer-lobster">et cetera:</h5>
        <p>&copy; 2011-2013 <span class="ezra-hub">Ezra Hub</span> version {{ Config::get('ezrahub.version_number') }} | If you have a question, email us at <a href="mailto:{{ Config::get('ezrahub.admin_email') }}">{{ Config::get('ezrahub.admin_email') }}</a> | <span class="ezra-hub">Ezra Hub</span> is <strong>not</strong> an official or endorsed publication of <a target="_blank" href="http://cornell.edu">Cornell University</a>. | Please take everything you see on this website with a grain of salt.</p>
    </div>
</footer>

<div id="threads-navigation">
    <nav class="sidebar-nav">
        <ul>
            <li class="browse option new-thread">
                <a href="/thread/new">
                    <span class="title icon-edit"></span>
                    <span class="selection">new thread</span>
                </a>
            </li>
            @if ($page_number != 1)
                <li class="browse option first-page">
                    <a href="/">
                        <span class="title icon-chevron-sign-up"></span>
                        <span class="selection">first page</span>
                    </a>
                </li>
                <li class="browse option previous-page">
                    <a href="/page/{{ $page_number - 1 }}">
                        <span class="title icon-chevron-sign-left"></span>
                        <span class="selection">prev. page</span>
                    </a>
                </li>
            @endif
            <li class="browse option next-page">
                <a href="/page/{{ $page_number + 1 }}">
                    <span class="title icon-chevron-sign-right"></span>
                    <span class="selection">next page</span>
                </a>
            </li>
            @if (Auth::check())
                <li class="user-link mark-all-as-read">
                    <span class="title icon-check"></span>
                    <span class="selection">mark all as read</span>
                </li>
                <li class="user-link me">
                    <a href="/user/me/" <?php if (Auth::user()->messages_to()->where('read', '=', 0)->count() > 0) { echo 'class="unread"'; } ?>>
                        {{ Avatar::generate('medium', Auth::user()) }}
                        {{ Reputation::generate(Auth::user()) }}
                        <span class="user-preview">
                            @if (Auth::user()->messages_to()->where('read', '=', 0)->count() > 0)
                                <span class="messages-indicator">
                                    <span class="icon-envelope-alt"></span>
                                    <span class="selection">{{ Auth::user()->messages_to()->where('read', '=', 0)->count() }}</span>
                                </span>
                            @endif
                        </span>
                    </a>
                </li>
                <li class="user-link smaller log-out">
                    <a href="/logout/">
                        <span class="title icon-signout"></span>
                        <span class="selection">log out</span>
                    </a>
                </li>
            @else
                <li class="user-link log-in">
                    <span class="title icon-signin"></span>
                    <span class="selection">log in or sign up</span>
                </li>
            @endif
        </ul>
    </nav>
</div>

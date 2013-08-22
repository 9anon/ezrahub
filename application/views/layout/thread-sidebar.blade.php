<div id="threads-navigation">
    <nav class="sidebar-nav">
        <ul>
            <li class="user-link reply">
                <span class="title icon-edit"></span>
                <span class="selection">reply</span>
            </li>
            <li class="user-link back">
                <a href="/">
                    <span class="title icon-reply"></span>
                    <span class="selection">home</span>
                </a>
            </li>
            @if (Auth::check())
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

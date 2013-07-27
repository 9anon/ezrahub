<div id="user-profile" data-id="{{ $user->id }}">
    <div id="profile-left-col">
        <div class="avatar-container">
            {{ Avatar::generate('large', $user) }}
            @if (Auth::check() && Auth::user()->id == $user->id /* this is our own profile */)
                <span class="edit-avatar">
                    <span class="icon-left icon-edit-sign"></span>
                    Change your avatar
                </span>
            @endif
        </div>
        @include('user.profile.info')
    </div>
    <div id="profile-right-col">
        <div id="user-profile-navigation">
            <nav>
                <ul>
                    <li class="unhoverable" data-option="back">
                        <a class="return" href="/">
                            <span class="icon-left icon-reply"></span>
                            Home
                        </a>
                    </li>
                    <li class="latest-posts active" data-option="latest-posts">
                        <span class="icon-left icon-comments"></span>
                        Latest posts
                    </li>
                    @if (Auth::check() && Auth::user()->id != $user->id && $user->id != 0 /* we can send a PM to this user, and we're not sending one to ourself or anon coward */)
                        <li class="new-message" data-option="new-message">
                            <span class="icon-left icon-edit-sign"></span>
                            Message {{ $user->name }}
                        </li>
                    @endif
                    <li class="latest-reps" data-option="latest-reps">
                        <span class="icon-left icon-sort-by-order"></span>
                        Rep given
                    </li>
                    @if (Auth::check() && Auth::user()->id != $user->id /* we are logged in and this is not our own profile */)
                        @if (Auth::user()->has_role('admin') || Auth::user()->has_role('mod') /* we are allowed to moderate */)
                            <li class="moderation" data-option="moderation">
                                <span class="icon-left icon-legal"></span>
                                Moderation
                            </li>
                        @endif
                    @endif
                    @if (Auth::check() && Auth::user()->id == $user->id /* this is our own profile */)
                        <li class="messages <?php if (Auth::user()->messages_to()->where('read', '=', 0)->count() > 0) { echo 'unread'; } ?>" data-option="messages">
                            @if (Auth::user()->messages_to()->where('read', '=', 0)->count() > 0)
                                <span class="messages-indicator unread">
                                    <span class="icon-left icon-envelope-alt"></span>
                                    Messages
                                </span>
                            @else
                                <span class="icon-left icon-envelope-alt"></span>
                                Messages
                            @endif
                        </li>
                        <li class="settings" data-option="settings">
                            <span class="icon-left icon-cogs"></span>
                            Account settings
                        </li>
                        <li class="unhoverable" data-option="log-out">
                            <a href="/logout" class="log-out-user">
                                <span class="icon-left icon-signout"></span>
                                Log out
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
            <div class="clear both"></div>
        </div>
        <div class="user-profile-item latest-posts">
           @include('user.profile.latest-posts')
        </div>
        @if (Auth::check() && Auth::user()->id != $user->id && $user->id != 0 /* we can send a PM to this user, and we're not sending one to ourself or anon coward */)
            <div class="user-profile-item new-message hidden">
                @include('user.profile.newmessage')
            </div>
        @endif
        <div class="user-profile-item latest-reps hidden">
           @include('user.profile.latest-reps')
        </div>
        @if (Auth::check() && Auth::user()->id == $user->id /* this is our own profile */)
            <div class="user-profile-item messages hidden">
                @include('user.profile.messages')
            </div>
            <div class="user-profile-item settings hidden">
                @include('user.profile.settings')
            </div>
        @endif
        @if (Auth::check() && Auth::user()->id != $user->id && Auth::user()->has_role('admin') || Auth::check() && Auth::user()->id != $user->id && Auth::user()->has_role('mod') /* we are allowed to moderate */)
            <div class="user-profile-item moderation hidden">
                @include('user.profile.moderation')
            </div>
        @endif
    </div>
    <div class="clear both"></div>
</div>

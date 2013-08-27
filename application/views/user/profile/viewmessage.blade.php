<div id="message-reading-pane-header">
    <nav>
        <ul>
            <li class="back-to-messages">
                <span class="icon-left icon-folder-open"></span> All Messages
            </li>
        </ul>
    </nav>
</div>
<div id="message-view">
    <div class="message-info">
        <a href="/user/{{ $message->from_user->name }}">
            {{ Avatar::generate('medium', $message->from_user) }}
        </a>
    </div>
    <div class="message-header">
        <h4>
            <span class="posted-by">
                <a href="/user/{{ $message->from_user->name }}">
                    <span class="username">{{ $message->from_user->name }}</span>
                </a>
                @if ($message->from_user->has_role('admin') || $message->from_user->has_role('mod'))
                    <span class="group">
                        @if ($message->from_user->has_role('admin'))
                            <span class="icon-key"></span>
                        @elseif ($message->from_user->has_role('mod'))
                            <span class="icon-bolt"></span>
                        @endif
                    </span>
                @endif
                {{ Reputation::generate($message->from_user) }}
            </span>
            <span class="post-ago">
                {{ PrettyPrint::time($message->created_at) }}
            </span>
        </h4>
    </div>
    <div class="post-body">
        {{ $message->message }}
    </div>
</div>
<div class="clear both"></div>


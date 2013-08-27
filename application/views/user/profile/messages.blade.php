<div id="messages-container">
    <div id="messages-header">
        <div class="messages-header-column"><span class="icon-left icon-user"></span> from</div>
        <div class="messages-header-column"><span class="icon-left icon-comment"></span> body</div>
        <div class="messages-header-column"><span class="icon-left icon-time"></span> sent</div>
        <div class="clear both"></div>
    </div>
    @if (empty($messages))
        <p>{{ $user->name }} has not received any reputation from other users yet :(</p>
    @else
        @foreach($messages as $message)
            <div class="message-item<?php if ($message->read == 0) { echo ' unread'; } ?>" id="message-{{ $message->id }}" data-message-id="{{ $message->id }}">
                <div class="message-unread">
                    @if($message->read == 0)
                        <span class="icon-unread icon-asterisk"></span>
                    @else
                        <span class="icon-ok"></span>
                    @endif
                </div>
                <div class="message-from">
                    {{ Avatar::generate('medium', $message->from_user) }}
                    <span class="username">{{ $message->from_user->name }}</span>
                    {{ Reputation::generate($message->from_user) }}
                </div>
                <div class="message-body">
                    {{ substr($message->message, 0, 100) }}
                </div>
                <div class="message-time">
                    {{ PrettyPrint::time($message->created_at) }}
                </div>
            </div>
        @endforeach
    @endif
</div>
<div id="message-reading-pane"></div>

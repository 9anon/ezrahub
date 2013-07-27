<div id="new-message">
    {{ Form::open('message/send/' . $user->id, 'POST', array('id' => 'new-message-form')); }}
        <div id="new-message-header">
            <p>You are sending a message to
                <a href="/user/{{ $user->name }}">
                    {{ Avatar::generate('small', $user) }}
                    <span class="username">{{ $user->name }}</span>
                </a>
                @if ($user->has_role('admin') || $user->has_role('mod'))
                    <span class="group">
                        @if ($user->has_role('admin'))
                            <span class="icon-key"></span>
                        @elseif ($user->has_role('mod'))
                            <span class="icon-bolt"></span>
                        @endif
                    </span>
                @endif
                . Messages are only viewable by the person you send them to. You may use all formatting available in normal posts.</p>
        </div>
        @include('inputs.textarea')
        <div class="clear both"></div>
        <div id="new-message-footer">
            <div id="errors">
                <p class="success"></p>
                <p class="errors"></p>
            </div>
            {{ Form::submit('Send a message to ' . $user->name, array('id' => 'post-new-message')); }}
        </div>
    {{ Form::close(); }}
</div>

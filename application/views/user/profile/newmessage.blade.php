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
        <div class='textarea-container'>
            <div class='textarea-formatting'>
                Write your message:
                <span title='bold' data-action='bold' class='format-icon icon-bold'></span>
                <span title='italic' data-action='italic' class='format-icon icon-italic'></span>
                <span title='heading' data-action='heading' class='format-icon icon-exclamation'></span>
                <span title='link' data-action='link' class='format-icon link icon-link'></span>
                <span title='image' data-action='image' class='format-icon image icon-camera'></span>
                <span title='youtube' data-action='youtube' class='format-icon youtube icon-youtube-play'></span>
                <span title='quote' data-action='quote' class='format-icon quote icon-quote-right'></span>
                <span title='list' data-action='list' class='format-icon list icon-list-ul'></span>
                <span title='strikethrough' data-action='strikethrough' class='format-icon strikethrough icon-strikethrough'></span>
                <div class='progress-display'>
                    <span class='rating-item'>
                        <span id='final-count'>0</span> <span class='noun'>words</span>:
                        <span class='rating'></span>
                    </span>
                    <span class='rating-item'>
                        <span id='stats'><span class="icon-dashboard"></span></span>
                        <span class='stats-rating'></span>
                    </span>
                </div>
                <div class="submit-container">
                    {{ Form::submit('Send your message', array('id' => 'post-new-message')); }}
                </div>
            </div>
            <p class="errors"></p>
            {{ Form::label('post-body', 'Body:'); }}
            {{ Form::textarea('post-body', null, array('placeholder' => 'Start writing here...', 'class' => 'enhanced')); }}
        </div>
        <div class="clear both"></div>
    {{ Form::close(); }}
</div>

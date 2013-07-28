<div id="new-thread">
    {{ Form::open('thread/new', 'POST', array('id' => 'new-thread-form')); }}
        <div id="new-thread-header">
            <div id="new-thread-title>">
                {{ Form::label('title', 'Title:'); }}
                {{ Form::text('title', null, array('placeholder' => 'Thread title')); }}
            </div>
        </div>
        <div class='textarea-container'>
            <div class='textarea-formatting'>
                Write a masterpiece of a thread:
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
                        <span id='final-count'>0</span> <span class='noun'>words</span> typed,
                        <span class='rating'></span>
                    </span>
                    <span class='rating-item'>
                        <span id='stats'>Intelligence:</span>
                        <span class='stats-rating'></span>
                    </span>
                </div>
                <div class="submit-container">
                    @if (Auth::check())
                        <span class="become-anon">Anonymous: {{ Form::checkbox('becomeanon', 'value', false) }}</span>
                    @endif
                    {{ Form::submit('Post a new thread', array('id' => 'post-new-thread')); }}
                </div>
            </div>
            <p class="errors"></p>
            @include('inputs.placeholders')
            {{ Form::label('post-body', 'Body:'); }}
            {{ Form::textarea('post-body', null, array('placeholder' => fill_placeholder(), 'class' => 'enhanced')); }}
        <div class="clear both"></div>
        @if (!Auth::check())
            <div id="anon-coward-form">
                <p class="anon-coward"><span class="icon-left icon-lock"></span> You're missing out on a lot of features as an Anonymous Coward, <strong>and</strong> you have to fill out this annoying captcha. Deal with this or <a target="_blank" class="log-in" href="/login/">create your own account in less than 20 seconds.</a></p>
                <script type="text/javascript">
                    var RecaptchaOptions = {
                        theme : 'custom',
                        custom_theme_widget: 'recaptcha_widget'
                    };
                </script>
                <div id="recaptcha_widget" style="display:none">
                    <div id="recaptcha_image"></div>
                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" placeholder="Enter the words you see to the left."/>
                    <div><a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a></div>
                    <div class="clear both"></div>
                </div>
                <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6Lc_teISAAAAAFLO6HFtDPxFT2yVdyLexJgmsP1j"></script>
                <noscript>
                    <iframe src="http://www.google.com/recaptcha/api/noscript?k=6Lc_teISAAAAAFLO6HFtDPxFT2yVdyLexJgmsP1j" height="300" width="500" frameborder="0"></iframe><br/>
                    <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                    <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
                </noscript>
            </div>
        @endif
        {{ Form::honeypot('date', 'date_time') }}
    {{ Form::close(); }}
</div>

<div class="new-reply-container">
    <div id="new-reply" <?php if (!Auth::check()) { echo 'class="anon-coward"'; } ?>>
        {{ Form::open('post/new/' .  $thread->id, 'POST', array('id' => 'new-reply-form')); }}
        <div class='textarea-container'>
            <div class='textarea-formatting'>
                Write a reply:
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
                    {{ Form::submit('Post a new reply to this thread', array('id' => 'post-new-reply')); }}
                    @if (Auth::check())
                        <div class="become-anon">
                            Anon
                            <span class="icon-right icon-unchecked"></span>
                        </div>
                    @endif
                    <div class="no-bump">
                        Nope <span class="icon-right icon-unchecked"></span>
                    </div>
                </div>
            </div>
            <p class="errors"></p>
            {{ Form::label('post-body', 'Body:'); }}
            {{ Form::textarea('post-body', null, array('placeholder' => 'Start writing here...', 'class' => 'enhanced')); }}
        </div>
        {{ Form::honeypot('date', 'date_time') }}
        <div class="clear both"></div>
        @if (!Auth::check())
            <div id="anon-coward-form">
                <p class="anon-coward"><span class="icon-left icon-lock"></span> You're missing out on a lot of features as an anonymous user, <strong>and</strong> you have to fill out this annoying captcha. Fill it out or <a target="_blank" class="log-in" href="/login/">create your own account in less than 20 seconds.</a></p>
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
    </div>
       {{ Form::close(); }}
    </div>
</div>

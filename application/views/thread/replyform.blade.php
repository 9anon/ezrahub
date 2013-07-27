<div class="new-reply-container">
    <div id="new-reply" <?php if (!Auth::check()) { echo 'class="anon-coward"'; } ?>>
        {{ Form::open('post/new/' .  $thread->id, 'POST', array('id' => 'new-reply-form')); }}
        @include('inputs.textarea')
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
        <p class="errors"></p>
        <div class="submit-container">
            <div class="submit-item no-bump">
                <span class="no-bump">Nope:</span>
                {{ Form::checkbox('nobump', 'value', false) }}
            </div>
            <div class="submit-item submit-button">
                {{ Form::submit('Post a new reply to this thread', array('id' => 'post-new-reply')); }}
            </div>
            <div class="clear both"></div>
        </div>
    </div>
       {{ Form::close(); }}
    </div>
</div>

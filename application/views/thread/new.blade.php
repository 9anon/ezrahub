<div id="new-thread">
    {{ Form::open('thread/new', 'POST', array('id' => 'new-thread-form')); }}
        <div id="new-thread-header">
            <div id="new-thread-title>">
                {{ Form::label('title', 'Title:'); }}
                {{ Form::text('title', null, array('placeholder' => 'Thread title')); }}
            </div>
        </div>
        @include('inputs.textarea')
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
        <p class="errors"></p>
        {{ Form::honeypot('date', 'date_time') }}
        {{ Form::submit('Post a new thread', array('id' => 'post-new-thread')); }}
    {{ Form::close(); }}
</div>

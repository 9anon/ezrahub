<div id="modal-container" class="log-in-sign-up">
    <div class="log-in-option log-in">
        <h2>log in or <span class="switch-option">sign up</span>:</h2>
        {{ Form::open('/login/', 'POST', array('id' => 'log-in-form')); }}
        <div class="form-row">
            {{ Form::label('username', 'username:'); }}
            {{ Form::text('username', null, array('placeholder' => 'username')); }}
        </div>
        <div class="form-row">
            {{ Form::label('password', 'password:'); }}
            {{ Form::password('password', array('placeholder' => 'password')); }}
        </div>
        <div class="form-row">
            <span>remember me?</span>
            {{ Form::checkbox('remember me', 'value', true); }}
        </div>
        <div class="form-row last">
            <p class="errors"></p>
        </div>
        {{ Form::submit('log in', array('class' => 'log-in-button')); }}
        {{ Form::close(); }}
    </div>
    <div class="log-in-option sign-up">
        <h2>sign up or <span class="switch-option">log in</span>:</h2>
        {{ Form::open('signup', 'POST', array('id' => 'sign-up-form')); }}
        <div class="form-row">
            {{ Form::label('name', 'name:'); }}
            {{ Form::text('name', null, array('placeholder' => 'pick a username')); }}
        </div>
        <div class="form-row">
            {{ Form::label('email', 'email:'); }}
            {{ Form::text('email', null, array('placeholder' => 'enter a valid email address')); }}
        </div>
        <div class="form-row">
            {{ Form::label('password', 'password:'); }}
            {{ Form::password('password', array('placeholder' => 'choose a password you will remember')); }}
        </div>
        <div class="form-row last">
            <p class="errors"></p>
        </div>
        {{ Form::submit('sign up', array('class' => 'sign-up-button')); }}
        {{ Form::close(); }}
    </div>
    <div class="clear both"></div>
</div>

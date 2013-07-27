<div class="settings-option edit-password">
    <h4><span class="icon-left icon-key"></span> Change your password</h4>
    {{ Form::open('/user/password/edit', 'POST', array('id' => 'edit-password-form')) }}
        <div class="form-row">
            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password', array('placeholder' => 'choose a password you will remember')) }}
        </div>
        <div class="form-row">
            {{ Form::label('password_confirm', 'Confirm your password:') }}
            {{ Form::password('password_confirm', array('placeholder' => 'type your password again')) }}
        </div>
        <div class="form-row">
            {{ Form::submit('Change password', array('id' => 'edit-password-submit')) }}
        </div>
        <div class="form-row last">
            <p class="success"></p>
            <p class="errors"></p>
        </div>
    {{ Form::close() }}
</div>
<div class="settings-option edit-email">
    <h4><span class="icon-left icon-envelope"></span> Update your email address</h4>
    {{ Form::open('/user/email/edit', 'POST', array('id' => 'edit-email-form')) }}
        <div class="form-row">
            {{ Form::label('email', 'email:'); }}
            {{ Form::text('email', null, array('placeholder' => 'enter your new email address')); }}
        </div>
        <div class="form-row">
            {{ Form::submit('Update email', array('id' => 'edit-email-submit')) }}
        </div>
        <div class="form-row last">
            <p class="success"></p>
            <p class="errors"></p>
        </div>
    {{ Form::close() }}
</div>
<div class="settings-option delete-avatar">
    <h4><span class="icon-left icon-frown"></span> Delete your avatar</h4>
    {{ Form::open('/user/avatar/delete', 'POST', array('id' => 'delete-avatar-form')) }}
        <div class="form-row">
            {{ Form::submit('Delete your avatar (warning!)', array('id' => 'delete-avatar-submit')) }}
        </div>
        <div class="form-row last">
            <p class="success"></p>
        </div>
    {{ Form::close() }}
</div>
<div class="settings-option disconnect-hal">
    <a class="return" href="/server_logic/disconnect">
        <span class="icon-left icon-warning-sign"></span>
        Disconnect server logic processor permanently
    </a>
</div>

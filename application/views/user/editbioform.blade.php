{{ Form::open('/user/bio/edit/', 'POST', array('id' => 'change-bio-form')) }}
    <div class="form-row">
        {{ Form::textarea('bio', $previous); }}
    </div>
    <div class="form-row">
        {{ Form::submit('Submit bio', array('id' => 'edit-bio-submit')); }}
    </div>
    <div class="form-row last">
        <p class="errors"></p>
    </div>
{{ Form::close() }}

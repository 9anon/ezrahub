<div id="modal-container" class="edit-avatar-form">
    <div class="modal-window">
        <h2>upload a new avatar:</h2>
        {{ Form::open_for_files('/user/avatar/edit/', 'POST', array('id' => 'change-avatar-form')) }}
            <div class="form-row">
                {{ Form::label('image', 'Image to upload:'); }}
                {{ Form::file('image'); }}
            </div>
            <div class="form-row">
                {{ Form::submit('Upload', array('id' => 'upload-new-avatar')); }}
            </div>
            <div class="form-row last">
                <div id="progress"></div>
                <p class="errors"></p>
            </div>
        {{ Form::close() }}
        <div class="clear both"></div>
    </div>
</div>

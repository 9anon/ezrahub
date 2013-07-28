<div id="edit-post">
    {{ Form::open('post/edit/' .  $post->id, 'POST', array('id' => 'edit-post-form', 'data-post-id' => $post->id)); }}
        <div class='textarea-formatting'>
            Edit your post:
            <span title='bold' data-action='bold' class='format-icon icon-bold'></span>
            <span title='italic' data-action='italic' class='format-icon icon-italic'></span>
            <span title='heading' data-action='heading' class='format-icon icon-exclamation'></span>
            <span title='link' data-action='link' class='format-icon link icon-link'></span>
            <span title='image' data-action='image' class='format-icon image icon-camera'></span>
            <span title='youtube' data-action='youtube' class='format-icon youtube icon-youtube-play'></span>
            <span title='quote' data-action='quote' class='format-icon quote icon-quote-right'></span>
            <span title='list' data-action='list' class='format-icon list icon-list-ul'></span>
            <span title='strikethrough' data-action='strikethrough' class='format-icon strikethrough icon-strikethrough'></span>
            <div class="submit-container">
                {{ Form::submit('Submit your changes', array('id' => 'submit-edited-post')); }}
            </div>
        </div>
        <p class="errors"></p>
        <textarea name="edited-body" id="edited-body" class="enhanced" cols="50" rows="10">{{ $post->body_raw }}</textarea>
    {{ Form::close(); }}
</div>

<div class='textarea-container'>
    {{ Form::label('post-body', 'Body:'); }}
    {{ Form::textarea('post-body', null, array('placeholder' => 'Type out a masterpiece...', 'class' => 'enhanced')); }}
    <div class='textarea-formatting'>
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
    </div>
</div>

@include('layout.index-sidebar')
<div id="threads" data-poll="1">
    <div id="no-sort-view">
        <div id="no-sort-header">
            <div class="no-sort-header-column">Welcome to the brand new <span class="ezra-hub">ezra hub</span> beta test, @include('home.taglines')</div>
            <div class="no-sort-header-column"><span class="icon-left icon-align-left"></span> Replies</div>
            <div class="no-sort-header-column"><span class="icon-left icon-comment"></span> Last post</div>
            <div class="clear both"></div>
        </div>
        <div id="threads-container">
            @include('home.threads')
        </div>
    </div>
    <div id="new-thread-container">
        @include('thread.new')
    </div>
</div>

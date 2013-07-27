@include('layout.index-sidebar')
<div id="threads" data-poll="1">
    <div id="no-sort-view">
        <div id="no-sort-header">
            <div class="no-sort-header-column">{{ Config::get('ezrahub.homepage_introduction') }}, @include('home.taglines')</div>
            <div class="no-sort-header-column"><span class="icon-left icon-align-left"></span> replies</div>
            <div class="no-sort-header-column"><span class="icon-left icon-comment"></span> last post</div>
            <div class="clear both"></div>
        </div>
        <div id="threads-container">
            <span class="no-threads-yet">No threads yet...</span>
        </div>
    </div>
    <div id="new-thread-container">
        @include('thread.new')
    </div>
</div>

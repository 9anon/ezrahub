@include('layout.index-sidebar')
<div id="threads" data-poll="1">
    <div id="no-sort-view">
        <div id="no-sort-header">
            <div class="no-sort-header-column">
                @if ($page_number == 1)
                    Welcome to the brand new <span class="ezra-hub">ezra hub</span> beta test, @include('home.taglines')
                @else
                    Viewing page {{ $page_number }} of results (threads {{ Config::get('ezrahub.num_homepage_threads') * ($page_number - 1) }}-{{ Config::get('ezrahub.num_homepage_threads') * ($page_number) }}). There are {{ Thread::count() }} threads total on Ezra Hub.
                @endif
            </div>
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

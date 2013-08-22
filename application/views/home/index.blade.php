@include('layout.index-sidebar')
<div id="threads" data-poll="1">
    <div id="no-sort-view">
        <div id="no-sort-header">
            <div class="no-sort-header-column">
                @if ($page_number == 1)
                    Welcome to the brand new <span class="ezra-hub">ezra hub</span> beta test, @include('home.taglines')
                @else
                    Viewing page {{ $page_number }} of results (threads {{ Config::get('ezrahub.num_homepage_threads') * ($page_number - 1) }}-{{ Config::get('ezrahub.num_homepage_threads') * ($page_number) }} out of {{ Thread::count() }} total on Ezra Hub).
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
<div id="pagination">
    Pagination:
    @if (max($page_number - 15, 1) != 1)
        <a href="/page/{{ $page_number - 15 }}" class="page-link"><span class="icon-circle-arrow-left"></span> (back 15 pages)</a>
    @endif
    @for ($i = max($page_number - 15, 1); $i <= min($max_pages, $page_number + 15); $i++)
        @if ($i == $page_number)
            <span class="page-link-current">{{ $i }}</span>
        @else
            <a href="/page/{{ $i }}" class="page-link">{{ $i }}</a>
        @endif
    @endfor
    @if (min($max_pages, $page_number + 15) != $max_pages)
        <a href="/page/{{ $page_number + 15 }}" class="page-link"><span class="icon-circle-arrow-right"></span> (forward 15 pages)</a>
    @endif
</div>

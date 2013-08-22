@include('layout.index-sidebar')
<div id="threads" data-poll="1">
    <div id="no-sort-view">
        <div id="no-sort-header">
            <div class="no-sort-header-column">
                @if ($page_number == 1)
                    <h1 class="subtitle">eh <span class="version-number">v{{ Config::get('ezrahub.version_number') }}</span></h1>
                    Welcome to <span class="ezra-hub">ezra hub</span> v{{ Config::get('ezrahub.version_number') }}, @include('home.taglines')
                @else
                    <h1 class="subtitle">eh <span class="version-number">v{{ Config::get('ezrahub.version_number') }}</span></h1>
                    Page {{ $page_number }} out of {{ $max_pages }} (threads {{ Config::get('ezrahub.num_homepage_threads') * ($page_number - 1) }}-{{ Config::get('ezrahub.num_homepage_threads') * ($page_number) }} out of {{ Thread::count() }})
                @endif
                <ul>
                @if ($page_number != 1)
                    <li class="first-page">
                        <a href="/">
                            <span class="title icon-chevron-sign-up"></span>
                            <span class="selection">home</span>
                        </a>
                    </li>
                    <li class="previous-page">
                        <a href="/page/{{ $page_number - 1 }}">
                            <span class="title icon-chevron-sign-left"></span>
                            <span class="selection">prev. page</span>
                        </a>
                    </li>
                @endif
                    <li class="next-page">
                        <a href="/page/{{ $page_number + 1 }}">
                            <span class="title icon-chevron-sign-right"></span>
                            <span class="selection">next page</span>
                        </a>
                    </li>
                </ul>
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
    @if (max($page_number - 10, 1) != 1)
        <a href="/page/{{ $page_number - 10 }}" class="page-link"><span class="icon-circle-arrow-left"></span> (back 10 pages)</a>
    @endif
    @if ($page_number - 1 >= 1)
        <a href="/page/{{ $page_number - 1 }}"><span class="title icon-chevron-sign-left"></span> previous page</a>
    @endif
    @for ($i = max($page_number - 10, 1); $i <= min($max_pages, $page_number + 10); $i++)
        @if ($i == $page_number)
            <span class="page-link-current">{{ $i }}</span>
        @else
            <a href="/page/{{ $i }}" class="page-link">{{ $i }}</a>
        @endif
    @endfor
    @if ($page_number + 1 <= $max_pages)
        <a href="/page/{{ $page_number + 1 }}"><span class="title icon-chevron-sign-right"></span> next page</a>
    @endif
    @if (min($max_pages, $page_number + 10) != $max_pages)
        <a href="/page/{{ $page_number + 10 }}" class="page-link"><span class="icon-circle-arrow-right"></span> (forward 10 pages)</a>
    @endif
    <span class="total-pages">
        {{ $max_pages }} pages total
    </span>
</div>

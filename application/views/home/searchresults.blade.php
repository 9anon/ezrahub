@include('layout.search-sidebar')
<div id="threads" data-poll="1">
    <div id="no-sort-view">
        <div id="no-sort-header">
            <div class="no-sort-header-column">Showing threads that match the query "{{ $query }}"</div>
            <div class="no-sort-header-column"><span class="icon-left icon-align-left"></span> Replies</div>
            <div class="no-sort-header-column"><span class="icon-left icon-comment"></span> Last post</div>
            <div class="clear both"></div>
        </div>
        <div id="threads-container" class="search-results-container">
            @include('home.threads')
        </div>
    </div>
</div>

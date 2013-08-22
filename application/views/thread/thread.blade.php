@include('layout.thread-sidebar')
<div id="thread" data-thread-id="{{ $thread->id }}">
    <div id="thread-topic-header">
        Did you know? @include('thread.factoids')
    </div>
    <div id="op-post" <?php if ($thread->user->id == 0) { echo 'class="anon-coward"'; } ?> data-post-id="{{ $op->id }}">
        <div class="post-header">
            {{ Avatar::generate('medium', $thread->user) }}
            <h2 class="op-title">
                {{ $thread->title }}
            </h2>
            <h3>
                posted by
                <a href="/user/{{ $thread->user->name }}"><span class="username">{{ $thread->user->name }}</span></a>
                @if ($thread->user->has_role('admin') || $thread->user->has_role('mod'))
                    <span class="group">
                        @if ($thread->user->has_role('admin'))
                            <span class="icon-key"></span>
                        @elseif ($thread->user->has_role('mod'))
                            <span class="icon-bolt"></span>
                        @endif
                    </span>
                @endif
                {{ Reputation::generate($thread->user) }}
                <span class="post-ago">
                    {{ PrettyPrint::time($thread->created_at) }}
                    on
                    {{ date("l, F j, Y", strtotime($thread->created_at)) . ' at ' . date("g:i a", strtotime($thread->created_at)) }}
                </span>
                @if (!empty($op->edited_by))
                    <span class="edited-info">
                        <span class="icon-wrench"></span> edited by {{ $op->edited_by }} {{ PrettyPrint::time($op->updated_at) }}
                    </span>
                @endif
            <span class="post-controls">
                <span class="quote"><span class="icon-quote-right"></span></span>
                @if (Auth::check() && Auth::user()->id == $thread->user->id || Auth::check() && Auth::user()->has_role('admin') || Auth::check() && Auth::user()->has_role('mod'))
                    <span class="edit thread"><span class="icon-edit"></span></span>
                    @if (Auth::check() && Auth::user()->has_role('admin') || Auth::check() && Auth::user()->has_role('mod'))
                        <span class="sticky-thread icon-pushpin mod"></span>
                        <span class="bump-lock-thread icon-arrow-down mod"></span>
                        <span class="lock-thread icon-lock mod"></span>
                    @endif
                    <span class="delete-thread"><span class="icon-trash"></span></span>
                @endif
            </span>
            <div class="clear both"></div>
        </div>
        <div class="post-body">
            {{ $op->body }}
        </div>
    </div>
    @include('thread.replies')
</div>
@if ($thread->lock == 1)
    @include('thread.locked')
@else
    @include('thread.replyform')
@endif
<div id="thread-scroll-header">
    <h1 class="subtitle">eh <span class="version-number">v{{ Config::get('ezrahub.version_number') }}</span></h1>
    <h2>
        <em>"{{ $thread->title }}"</em>
        posted by
        {{ Avatar::generate('small', $thread->user) }}
        {{ $thread->user->name }}
        {{ Reputation::generate($thread->user) }}
        {{ Prettyprint::time($thread->created_at) }}
        on
        {{ date("l, F j, Y", strtotime($thread->created_at)) . ' at ' . date("g:i a", strtotime($thread->created_at)) }}
    </h2>
    <div class="clear both"></div>
</div>

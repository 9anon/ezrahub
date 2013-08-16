@foreach($threads as $thread)
    <?php if (Auth::check() && $thread->threadviews()->where('user_id', '=', Auth::user()->id)->where('updated_at', '>=', $thread->updated_at)->count() == 0) { $unread = true; } else { $unread = false; } ?>
    <div class="thread-row<?php if ($thread->sticky) { echo ' sticky'; } if ($thread->lock) { echo ' locked'; } if ($unread == true) { echo ' unread'; } ?>" data-thread-id="{{ $thread->id }}">
        <div class="thread-header">
            <div class="thread-indicators">
                <span class="icon-indicator icon-ellipsis-vertical"></span>
                @if ($thread->sticky)
                    <span class="icon-sticky icon-pushpin"></span>
                @endif
                @if ($thread->lock == 1)
                    <span class="icon-locked icon-lock"></span>
                @endif
                @if ($unread)
                    <span class="icon-unread icon-asterisk"></span>
                @endif
            </div>
            <h3>
                <a class="thread-link" href="/thread/{{ $thread->id }}/{{ $thread->slug }}">
                    <span class="thread-title">{{ $thread->title }}</span>
                </a>
            </h3>
        </div>
        <div class="thread-subtitle">
            posted by
            {{ Avatar::generate('small', $thread->user) }}
            <a href="/user/{{ $thread->user->name }}">
                <span class="username">{{ $thread->user->name }}</span>
            </a>
            @if (!empty($thread->posts()->order_by('created_at', 'asc')->first()->edited_by))
                <span class="edited-info">and edited</span>
            @endif
            {{ Reputation::generate($thread->user) }}
            <span class="icon-time"></span>
            <span class="post-ago"> {{ PrettyPrint::time($thread->created_at) }}</span>
            on
            {{ date("l, F j, Y", strtotime($thread->created_at)) . ' at ' . date("g:i a", strtotime($thread->created_at)) }}
        </div>
        <div class="thread-content-preview">
            <p>{{ substr($thread->posts()->order_by('created_at', 'asc')->first()->body_raw, 0, 1000) }}</p>
        </div>
        <div class="thread-replies">
            <?php $last_post = $thread->posts()->order_by('created_at', 'desc')->first(); ?>
            <a href="/user/{{ $last_post->user->name }}">
                <span class="username">{{ $last_post->user->name }}</span>
            </a>
            posted last
            <span class="post-ago">{{ PrettyPrint::time($last_post->created_at) }}</span>
            |
            <span class="icon-comments"></span>
            {{ PostCount::generate($thread) }} to this thread.
        </div>
        <div class="clear both"></div>
    </div>
@endforeach

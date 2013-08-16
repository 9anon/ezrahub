@foreach($threads as $thread)
    <?php if (Auth::check() && $thread->threadviews()->where('user_id', '=', Auth::user()->id)->where('updated_at', '>=', $thread->updated_at)->count() == 0) { $unread = true; } else { $unread = false; } ?>
    <div class="thread-row<?php if ($thread->sticky) { echo ' sticky'; } if ($thread->lock) { echo ' locked'; } if ($unread == true) { echo ' unread'; } ?>" data-thread-id="{{ $thread->id }}">
        <div class="main-section">
            <div class="thread-column thread-indicators">
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
            <div class="thread-column thread-title">
                <h3>
                    <a class="thread-link" href="/thread/{{ $thread->id }}/{{ $thread->slug }}">
                        <span class="thread-title">{{ $thread->title }}</span>
                        <span class="post-ago"> {{ PrettyPrint::time($thread->created_at) }}</span>
                        by
                        <span class="username">{{ $thread->user->name }}</span>
                        @if (!empty($thread->posts()->order_by('created_at', 'asc')->first()->edited_by))
                            <span class="edited-info">
                                <span class="icon-wrench"></span>
                            </span>
                        @endif
                    </a>
                </h3>
            </div>
        </div>
        <div class="secondary-section">
            <div class="thread-column thread-replies">
                <p>{{ PostCount::generate($thread) }}</p>
            </div>
            <?php $last_post = $thread->posts()->order_by('created_at', 'desc')->first(); ?>
            <div class="thread-column thread-latest-post<?php if ($last_post->user->id == 0) { echo ' anon-coward'; } ?>">
                <p>
                    {{ Avatar::generate('small', $last_post->user) }}
                    <a href="/user/{{ $last_post->user->name }}">
                        <span class="username">{{ $last_post->user->name }}</span>
                    </a>
                    <span class="post-ago">{{ PrettyPrint::time($last_post->created_at) }}</span>
                </p>
            </div>
        </div>
        <div class="clear both"></div>
    </div>
@endforeach

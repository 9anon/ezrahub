@foreach($posts as $post)
    <div class="thread-reply<?php if ($post->user->id == 0) {echo ' anon-coward';} ?>" id="post-{{ $post->id }}" data-post-id="{{ $post->id }}">
        <div class="reply-info">
            <a href="/user/{{ $post->user->name }}">
                {{ Avatar::generate('medium', $post->user) }}
            </a>
        </div>
        <div class="reply-header">
            <h4>
                <span class="posted-by">
                    <a href="/user/{{ $post->user->name }}">
                        <span class="username">{{ $post->user->name }}</span>
                    </a>
                    @if ($post->user->has_role('admin') || $post->user->has_role('mod'))
                        <span class="group">
                            @if ($post->user->has_role('admin'))
                                <span class="icon-key"></span>
                            @elseif ($post->user->has_role('mod'))
                                <span class="icon-bolt"></span>
                            @endif
                        </span>
                    @endif
                    {{ Reputation::generate($post->user) }}
                </span>
                wrote
                <span class="post-ago">
                    {{ PrettyPrint::time($post->created_at) }}
                </span>
                @if (!empty($post->edited_by))
                    <span class="edited-info">
                        <span class="icon-wrench"></span> edited by {{ $post->edited_by }} {{ PrettyPrint::time($post->updated_at) }}
                    </span>
                @endif
                <span class="post-controls">
                    <span class="quote"><span class="icon-quote-right"></span></span>
                    @if (Auth::check() && Auth::user()->id == $post->user->id || Auth::check() && Auth::user()->has_role('admin') || Auth::check() && Auth::user()->has_role('mod'))
                        <span class="edit"><span class="icon-edit"></span></span>
                        <span class="delete-post"><span class="icon-trash"></span></span>
                    @endif
                </span>
            </h4>
        </div>
        <div class="post-body">
            {{ $post->body }}
        </div>
        <div class="clear both"></div>
    </div>
@endforeach


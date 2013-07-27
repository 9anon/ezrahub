@if (empty($last_posts))
    <p class="no-posts-yet">{{ $user->name }} has not made any posts yet :(</p>
@else
    @foreach($last_posts as $post)
        <div class="latest-post">
            <div class="thread-in">
                <h4>
                    {{ $user->name }} posted in
                    <a target="_blank" href="/thread/{{ $post->thread->id }}/{{ $post->thread->slug }}">{{ $post->thread->title }}</a>
                    <span class="post-ago">
                        {{ PrettyPrint::time($post->created_at) }}
                    </span>
                </h4>
            </div>
            <div class="thread-reply">
                <div class="post-body">
                    {{ $post->body }}
                </div>
                <div class="clear both"></div>
            </div>
        </div>
    @endforeach
@endif

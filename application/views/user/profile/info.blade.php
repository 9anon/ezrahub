<div class="user-info">
    <h2>{{ $user->name }}</h2>
    <p>
        <b>Reputation:</b>
        {{ Reputation::generate($user) }}
    </p>
    @if ($user->has_role('admin') || $user->has_role('mod'))
        <p>
            <b>Responsibilities:</b>
            <span class="group">
                @if ($user->has_role('admin'))
                    <span class="icon-key" title="admin"></span>
                @elseif ($user->has_role('mod'))
                    <span class="icon-bolt" title="mod"></span>
                @endif
            </span>
        </p>
    @endif
    <p>
        <b>Join date:</b>
        <span class="join-date">
            {{ date('F j, Y', strtotime($user->created_at)) }}
        </span>
    <p>
        <b>Last seen:</b>
        <span class="last-seen">
            {{ date('F j, Y', strtotime($user->last_seen)) }}
        </span>
    </p>
    @if (Auth::check() && Auth::user()->id == $user->id || Auth::check() && Auth::user()->has_role('admin') /* this is our own profile or we're an admin */)
        <p>
            <b>Email (only visible to you):</b>
            <span class="email">
                <a target="_blank" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
            </span>
        </p>
    @endif
    @if (Auth::check() && Auth::user()->has_role('admin'))
        <p>
            <b>Last login IP:</b>
            <span class="ip-address">
                <span class="icon-left icon-eye-open"></span><a target="_blank" href="">{{ $user->ip }}</a>
            </span>
        </p>
    @endif
    <p>
        <b>Bio:</b>
        <span class="user-bio">
            @if (empty($user->bio))
                <span class="faded-out">nothing here yet...</span>
            @else
                {{ $user->bio }}
            @endif
        </span>
        @if (Auth::check() && Auth::user()->id == $user->id /* this is our own profile */)
            <span class="edit-bio">
                <span class="icon-left icon-edit-sign"></span>
                Edit your bio
            </span>
        @endif
    </p>
</div>

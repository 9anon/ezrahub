<div id="rep-header">
    <div class="rep-header-column"><span class="icon-left icon-user"></span> given by</div>
    <div class="rep-header-column"><span class="icon-left icon-bolt"></span> amount</div>
    <div class="rep-header-column"><span class="icon-left icon-comment"></span> comment</div>
    <div class="rep-header-column"><span class="icon-left icon-time"></span> time</div>
    <div class="clear both"></div>
</div>
<div id="rep-tally">
    <span class="icon-left icon-asterisk"></span> {{ $user->name }}'s exact reputation to two decimal places is {{ $user->reputation_raw / 100 }}, which rounds to {{ $user->reputation }}.
</div>
@if (empty($last_reps))
    <p>{{ $user->name }} has not received any reputation from other users yet :(</p>
@else
    @foreach($last_reps as $last_rep)
        <div class="rep-item">
            <div class="rep-giver">
                {{ Avatar::generate('medium', $last_rep->from_user) }}
                <a href="/user/{{ $last_rep->from_user->name }}">
                    <span class="username">
                        {{ $last_rep->from_user->name }}
                    </span>
                </a>
                {{ Reputation::generate($last_rep->from_user) }}
            </div>
            <div class="rep-amount-given<?php if ($last_rep->sign == -1) { echo ' negative'; } ?>">
                @if ($last_rep->sign == 1)
                    <span class="icon-plus-sign"></span>
                @else
                    <span class="icon-minus-sign"></span>
                @endif
                    {{ $last_rep->rep_amount / 100 }}
            </div>
            <div class="rep-comment">
                "{{ $last_rep->comment }}"
            </div>
            <div class="rep-time">
                {{ PrettyPrint::time($last_rep->created_at) }}
            </div>
        </div>
    @endforeach
@endif

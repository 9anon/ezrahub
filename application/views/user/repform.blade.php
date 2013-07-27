<div id="modal-container" class="rep-neg">
    <div class="modal-window rep-neg">
        @if(!Auth::check())
            <p>Sorry, you need to be logged in to rep or neg. <br/><br/> Why not <a class="log-in" href="/login/">log in or sign up</a>?</p>
        @elseif (Auth::check() && Auth::user()->id == $user->id)
            <p>Sorry, you can't rep or neg yourself.</p>
        @else
            <h2>Add to this user's reputation:</h2>
            {{ Form::open('#', 'POST', array('id' => 'submit-rep-form', 'data-user-id' => $user->id)); }}
                <h3>
                    {{ Avatar::generate('medium', $user) }}
                    <span class="rep-row">
                        <span class="highlight">{{ $user->name }}</span>
                        @if ($user->has_role('admin') || $user->has_role('mod'))
                            <span class="group">
                                @if ($user->has_role('admin'))
                                    <span class="icon-key"></span>
                                @elseif ($user->has_role('mod'))
                                    <span class="icon-bolt"></span>
                                @endif
                            </span>
                        @endif
                    </span>
                    <span class="rep-row">
                        {{ Reputation::generate($user) }}
                    </span>
                </h3>
                <div class="clear both"></div>
                <div class="rep-actions">
                    <div class="rep" data-action="up">
                        <span class="icon-left icon-plus"></span>
                        rep
                    </div>
                    <div class="neg" data-action="down">
                        <span class="icon-left icon-minus"></span>
                        neg
                    </div>
                </div>
                <div class="rep-comment">
                    <p>Please elaborate:</p>
                    {{ Form::text('comment', null, array('placeholder' => 'Shh no tears... only dreams now.')); }}
                </div>
                <p class="errors"></p>
                {{ Form::submit('Submit', array('class' => 'submit-rep')); }}
            {{ Form::close() }}
        @endif
    </div>
</div>

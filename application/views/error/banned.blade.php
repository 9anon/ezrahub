<div id="modal-form" class="you-are-banned">
    <h2>you have been banned</h2>
    <img src="/img/slothneg.gif" alt="sloth neg gif" width="700" height="336">
    <p>Sloth neg of peace. Welp, looks like you have been banned. You broke the rules, and this is what we have to do when you break them. If you are confused, please make yourself aware of our <a target="_blank" href="/rules/">simple and easy-to-understand rules</a>. We don't like banning people and we wish we never had to, but rules are rules and we enforce them.</p>
    <p>
        <b>You were banned for:</b>
        <span class="ban-highlight">
            {{ $ban->message }}
        </span>
    </p>
    <p><b>Your IP address is:</b> <span class="ban-highlight">{{ Request::ip() }}</span></p>
    <p>All bans are <b>NON-NEGOTIABLE</b> and trying to argue about them is going to get you in even more trouble. Just wait out the ban, come back, and be a better person on <span class="ezra-hub">ezra hub</span>.</p>
    <p><b>Your ban will expire on:</b> <span class="ban-highlight">{{ date('F j, Y \a\t g:i a', strtotime($ban->expires_at)) }}</a></p>
</div>
<object width="1" height="1"><param name="movie" value="http://www.youtube.com/v/7wFxoU53-qU&autoplay=1"></param><embed src="http://www.youtube.com/v/7wFxoU53-qU&autoplay=1" type="application/x-shockwave-flash" width="1" height="1"></embed></object>

<div id="new-ban">
    <h2>You are going to ban:</h2>
    <?php echo Form::open('mod/ban/user/' . $user_to->id, 'POST', array('id' => 'new-ban-form')); ?>
    <div id="new-ban-header">
        {{ Avatar::generate('medium', $user_to) }}
        <span class="username">{{ $user_to->name }}</span>
        <span class="group">
            <?php
            if ($user_to->has_role('admin')) {
                echo '<span class="icon-heart"></span>';
            } else if ($user_to->has_role('mod')) {
                echo '<span class="icon-legal"></span>';
            }
            ?>
        </span>
        {{ Reputation::generate($user_to) }}
        <p class="email">email: <a target="_blank" href="mailto:{{ $user_to->email }}">{{ $user_to->email }}</a></p>
        <p class="last-ip">last IP: <a target="_blank" href="http://whatismyipaddress.com/ip/{{ $user_to->ip }}">{{ $user_to->ip }}</a></p>
    </div>
    <div class="clear both"></div>
    <div class='ban-options'>
        <div class="form-row">
            <h3>ban expiration:</h3>
            <?php echo Form::label('expiration-date', 'expiration-date:'); ?>
            <?php echo Form::text('expiration-date', '', array('id' => 'expiration-date')); ?>
        </div>
        <div class="form-row">
            <h3>ban reason:</h3>
            <?php echo Form::label('ban-reason', 'ban-reason:'); ?>
            <?php echo Form::textarea('ban-reason', '', array('id' => 'ban-reason', 'class' => 'enhanced')); ?>
        </div>
    </div>
    <div id="errors">
    @if (!Auth::check())
        <p class="anon-coward"><span class="icon left icon-lock"></span> You're missing out on a lot of features as an Anonymous Coward, why not <a target="_blank" href="/signup/">create your own account in less than 20 seconds?</a></p>
    @endif
    </div>
    <?php echo Form::submit('Ban ' . $user_to->name, array('id' => 'ban-submit')); ?>
    <?php echo Form::close(); ?>
</div>

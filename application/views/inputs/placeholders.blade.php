<?php

function fill_placeholder() {

    $placeholders[] = 'Dude, i\'m gonna type as sober as possible, that honestly looks fcking pathetic and digusting compared to my meal. and I\'m being one hundred...';
    $placeholders[] = 'I think you might have something wrong with your brain. Why are you trying to be all cyberbully on me. Do you really think...';
    $placeholders[] = 'I\'ve seen what getting jizzed on by a group of people does to a man, it is not pretty. I wasn\'t a part of it but when I was 12...';
    $placeholders[] = 'Dude I can\'t stand listening to your jargon anymore. The fact that you talk a lot of **** that you can not back makes me believe that you do a lot of reading and not a lot of lifting...';
    $placeholders[] = 'When I was 12 I had my first sexual experience. At the time, I lived in a little suburb outside of Cleveland and anyway, the girl next door and I...';
    $placeholders[] = 'I never bought any of that "size matters" crap until my junior year in college. I lived in the dorms with two roommates, David and John. David was a pretty ordinary...';
    $placeholders[] = 'Honestly, that\'s what I call a cool story bro. Such a riveting tale, I honestly copy and pasted it to word, saved on my hard drive, backed it up on a...';
    $placeholders[] = 'You’ve got to be kidding me. I’ve been further even more decided to use even go need to do look more as anyone can. Can you really be far even as decided..';
    $placeholders[] = 'Allow me to play doubles advocate here for a moment. For all intensive purposes I think you are wrong. In an age where...';
    $placeholders[] = 'Your eyes are too far apart. Nose is definitely crooked. The shape of your face is not aesthetically pleasing at all. You look like a 3/10 with make up in this photo...';

    return $placeholders[rand(0,count($placeholders)-1)];
}

?>

<?php

function random_placeholder() {
    //create an array of facts about me
    $placeholders[] = 'do you even lift';
    $placeholders[] = 'skorton murphy zoner 3some pics';
    $placeholders[] = 'gitlin tep hazing scandal';
    $placeholders[] = 'yoga pants sexy ass';
    $placeholders[] = 'how to know if you\'re gay';
    $placeholders[] = 'difference between penn upenn';
    $placeholders[] = 'i\'m fawkin zeez brah';
    $placeholders[] = 'sigma pi racists bottle';
    $placeholders[] = 'cornell frat rankings ' . date("Y");
    $placeholders[] = 'cornell sorority rankings ' . date("Y");
    $placeholders[] = 'psi u cocaine where to buy';
    $placeholders[] = 'uris library orgy';
    $placeholders[] = 'how to hack studentcenter';
    $placeholders[] = 'jeff seid shirtless pics';
    $placeholders[] = 'peeper and the blonde';
    $placeholders[] = 'where is cornell hub';
    $placeholders[] = 'joanna guy miss maryland';
    $placeholders[] = 'jeff seid 100 squat';
    $placeholders[] = 'cornell who is bgfe';
    $placeholders[] = 'cornell dsp vs. akpsi';
    $placeholders[] = 'when do level b bouncers change';
    $placeholders[] = 'cornell easy pam classes';
    $placeholders[] = 'cammy knight library porn';

    //pick a random position in the array and store it in num
    $num = rand(0,count($placeholders)-1);
    //return the chosen fact
    return $placeholders[$num];
}

?>

<?php

class PostCount {
    static function generate($thread) {

        $post_count = $thread->posts()->count() - 1;

        if ($post_count == 0) {
            $class = 'no-replies';
            $string = 'no replies';
        } elseif ($post_count >= 100) {
            $class = 'most-replies';
            $string =  '<span class="icon-star"></span> ' . $post_count . ' replies';
        } elseif($post_count >= 50) {
            $class = 'even-more-replies';
            $string = $post_count . ' replies';
        } elseif($post_count >= 25) {
            $class = 'more-replies';
            $string = $post_count . ' replies';
        } elseif ($post_count > 1) {
            $class = 'some-replies';
            $string = $post_count . ' replies';
        } else {
            $class = 'one-reply';
            $string = '1 reply';
        }

        return '<span class="' . $class . '">' . $string . '</span>';

    }
}

?>

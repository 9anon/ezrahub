<?php

class PostCount {
    static function generate($thread) {

        $post_count = $thread->posts()->count() - 1;

        if ($post_count == 0) {
            $class = 'no-replies';
            $string = 'none';
        } elseif ($post_count >= 100) {
            $class = 'most-replies';
            $string =  '<span class="icon-star"></span> ' . $post_count;
        } elseif($post_count >= 50) {
            $class = 'even-more-replies';
            $string = '<span class="icon-circle"></span> ' . $post_count;
        } elseif($post_count >= 25) {
            $class = 'more-replies';
            $string = '<span class="icon-circle"></span> ' . $post_count;
        } elseif ($post_count > 1) {
            $class = 'some-replies';
            $string = '<span class="icon-circle"></span> ' . $post_count;
        } else {
            $class = 'one-reply';
            $string = '<span class="icon-circle"></span> 1';
        }

        return '<span class="' . $class . '">' . $string . '</span>';

    }
}

?>

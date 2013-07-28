<?php

class BBCode {
    /**
     * Parse text and replace with relevant BBCode
     *
     * @access  public
     * @param   string  $data
     * @return  string
     */
    public static function parse($data) {
        // Replace [b]...[/b] with <strong>...</strong>
        $matches["/\[b\](.*?)\[\/b\]/is"] = function($match) {
            return HTML::strong($match[1]);
        };

        // Replace [i]...[/i] with <em>...</em>
        $matches["/\[i\](.*?)\[\/i\]/is"] = function($match) {
            return HTML::em($match[1]);
        };

        // Replace [quote]...[/quote] with <blockquote><p>...</p></blockquote>
        $matches["/\[quote\](.*?)\[\/quote\]/is"] = function($match) {
            return HTML::quote($match[1]);
        };

        // Replace [quote="person"]...[/quote] with <blockquote><p>...</p></blockquote>
        $matches["/\[quote=\"([^\"]+)\"\](.*?)\[\/quote\]/is"] = function($match) {
            return HTML::quote('<span class="quoted-user">' . $match[1] . '</span> wrote: ' . $match[2]);
        };

        // Replace [h]...[/h] with <h5>...</h5>
        $matches["/\[h\](.*?)\[\/h\]/is"] = function($match) {
            return '<h5>' . $match[1] . '</h5>';
        };

        // Replace [s] with <del>
        $matches["/\[s\](.*?)\[\/s\]/is"] = function($match) {
            return HTML::del($match[1]);
        };

        // Replace [url]...[/url] with <a href="...">...</a>
        $matches["/\[url\](.*?)\[\/url\]/is"] = function($match) {
            return HTML::link($match[1], $match[1], array('target' => '_blank', 'rel' => 'external nofollow'));
        };

        // Replace [img]...[/img] with <img src="..."/>
        $matches["/\[img\](.*?)\[\/img\]/is"] = function($match) {
            return '<a target="_blank" href="' . $match[1] . '"><img src="' . $match[1] . '" alt="' . $match[1] . '"></a><div class="clear both"></div>';
        };

        // Replace [list]...[/list] with <ul><li>...</li></ul>
        $matches["/\[list\](.*?)\[\/list\]/is"] = function($match) {
            preg_match_all("/\[\*\]([^\[\*\]]*)/is", $match[1], $items);

            return HTML::ul(preg_replace("/[\n\r?]$/", null, $items[1]));
        };

        // Replace [youtube]...[/youtube] with <iframe src="..."></iframe>
        $matches["/\[youtube\]([A-Z0-9\-_]+)(?:&(.*?))?\[\/youtube\]/i"] = function($match) {
            return HTML::iframe('http://www.youtube-nocookie.com/embed/' . $match[1], array(
                'class'         => 'youtube-player',
                'type'          => 'text/html',
                'width'         => 560,
                'height'        => 315,
                'frameborder'   => 0
            ));
        };

        // Replace everything that has been found
        foreach($matches as $key => $val) {
            $data = preg_replace_callback($key, $val, $data);
        }

        //return the formatted post
        return BBCode::nl2p($data, false);
    }

    public static function nl2p($string) {
        return '<p>' . preg_replace(
                            array("/([\n]{2,})/i", "/([\r\n]{3,})/i", "/([^>])\n([^<])/i"),
                            array("</p>\n<p>", "</p>\n<p>", '$1<br/>$2'),
                            trim($string)
                        ) . '</p>';
    }
}

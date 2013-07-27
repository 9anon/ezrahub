<?php

class HTML extends \Laravel\HTML {
    /**
     * Generate an strong element.
     *
     * @access  public
     * @param   string  $data
     * @return  string
     */
    public static function strong($data) {
        return '<strong>' . $data . '</strong>';
    }

    /**
     * Generate an em element.
     *
     * @access  public
     * @param   string  $data
     * @return  string
     */
    public static function em($data) {
        return '<em>' . $data . '</em>';
    }

    /**
     * Generate an code element.
     *
     * @access  public
     * @param   string  $data
     * @return  string
     */
    public static function code($data) {
        return '<pre><code>' . $data . '</code></pre>';
    }

    /**
     * Generate an blockquote element.
     *
     * @access  public
     * @param   string  $data
     * @return  string
     */
    public static function quote($data) {
        return '<blockquote><p>' . $data . '</p></blockquote>';
    }

    /**
     * Generate an del (strikethrough) element.
     *
     * @access  public
     * @param   string  $data
     * @return  string
     */
    public static function del($data) {
        return '<del>' . $data . '</del>';
    }

    /**
     * Generate an iframe element.
     *
     * @access  public
     * @param   string  $url
     * @param   array   $attributes
     * @return  string
     */
    public static function iframe($url, $attributes = array()) {
        return '<iframe src="' . $url . '"' . static::attributes($attributes) . '></iframe>';
    }
}

?>

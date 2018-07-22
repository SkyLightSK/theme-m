<?php
/**
 * Interface for WordPress custom post types.
 */
interface Post_Type_Interface
{
    /**
     * Get all the post meta as a key-value associative array.
     *
     * @return array
     */
    public function get_post_meta();

    /**
     * Get the post price value.
     *
     * @return float
     */
    public function getPrice();

    /**
     * Get all the post meta as a key-value associative array.
     *
     * @return bool
     */
    public function isInStock();

    /**
     * Get the post meta gallery.
     *
     * @return array
     */
    public function getGallery();

}

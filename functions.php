<?php
/**
 * Mogul functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mogul
 */

require get_template_directory() . '/inc/Init.php';

$init = new Init();
$init->run();

/**
 *  New Product Post Type
 */
require_once get_template_directory() . '/inc/Product.php';
require_once get_template_directory() . '/inc/Product_Post.php';

$new_cpt_product = new Product('product');
$new_cpt_product->make('product','Product','Product', 'dashicons-cart');

$product_post = new Product_Post( array( 'ID' => 346, 'post_type' => 'product' ) );
$product_post->getPrice();
$product_post->isInStock();
$product_post->getGallery();
$product_post->post;
$product_post->post->post_title;
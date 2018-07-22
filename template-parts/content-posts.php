<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mogul
 */

if ( have_posts() ) :

    while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', get_post_format() );

    endwhile;

    $pagination = get_the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'mogul' ),
        'next_text'          => __( 'Next page', 'mogul' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'mogul' ) . ' </span>',
    ) );

    echo str_replace( admin_url( 'admin-ajax.php/' ), get_category_link( $cat->term_id ), $pagination );

else :

    get_template_part( 'template-parts/content', 'none' );

endif;
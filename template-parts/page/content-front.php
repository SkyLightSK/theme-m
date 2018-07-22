<?php
/**
 * Displays content for front page
 *
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'mogul-panel ' ); ?> >
    <div class="panel-content">
        <div class="container wrap">
            <div class="entry-content">
                <div class="entry-content-content-wrap">
                <?php
                    /* translators: %s: Name of current post */
                    the_content( sprintf(
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mogul' ),
                        get_the_title()
                    ) );

                    if ( has_post_thumbnail() ) :

                        $thumbnail = wp_get_attachment_image_url( get_post_thumbnail_id( $post->ID ), 'mogul-featured-image' ); ?>
                        <div class="entry-content-thumbnail-wrap">
                            <img src="<?php echo $thumbnail; ?>" class="rounded mx-auto d-block" alt="mogul-front-page-photo">
                        </div><?php

                    endif;

                    if(get_field('sec_description')):

                        the_field('sec_description');

                    endif;

                    if(get_field('sec_thumbnail')):?>

                        <div class="entry-content-thumbnail-wrap">
                            <img src="<?php the_field('sec_thumbnail'); ?>" class="rounded mx-auto d-block" alt="mogul-front-page-photo">
                        </div><?php

                    endif;

                    if(get_field('sec_description')):

                        the_field('contacts');

                    endif;
                ?>
                </div>
            </div><!-- .entry-content -->

        </div><!-- .wrap -->
    </div><!-- .panel-content -->

</article><!-- #post-## -->
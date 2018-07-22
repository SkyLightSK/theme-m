<?php
/**
 *
 * Template Name: Blog
 *
 */

get_header();
?>
    <div class="container-fluid">
        <div class="row">
            <div id="primary" class="content-area col-lg-9 col-lx-9">
                <main id="main" class="site-main mogul-posts-main">
                    <?php
                    $query = new WP_Query(array(
                        'post_type' => 'post'
                    ));

                    if ( $query->have_posts() ) :

                        /* Start the Loop */
                        while ( $query->have_posts() ) :
                            $query->the_post();

                            /*
                             * Include the Post-Type-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/content', $query->get_post_type() );

                        endwhile;

                        wp_reset_postdata();

                        the_posts_navigation();

                    else :

                        get_template_part( 'template-parts/content', 'none' );

                    endif;
                    ?>

                </main><!-- #main -->
            </div><!-- #primary -->
            <?php get_sidebar(); ?>
        </div>
    </div>
<?php

get_footer();

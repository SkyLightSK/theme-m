<?php
/**
 *
 *  Template Name: Reviews
 *
 */

get_header();
?>
    <div class="container-fluid">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <header class="page-header">
                    <div class="container ">
                        <h1 class="page-title text-center"><?php the_title() ?></h1>
                    </div>
                </header><!-- .page-header -->
                <?php

                $query = new WP_Query(array(
                        'posts_per_page' => 6,
                        'paged' => 1,
                        'post_type' => 'review',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'review',
                                'field' => 'slug',
                                'terms' => array('portfolio', 'services'))
                )));

                if ( $query->have_posts() ) : ?>
                    <div class="container review-list-container">
                        <div class="row review-list">
                            <?php

                                /* Start the Loop */
                                while ( $query->have_posts() ) :
                                    $query->the_post();
                                    /*
                                     * Include the Post-Type-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                     */?>
                                    <div class="col-lg-6 review-list-col">
                                        <div class="review-list-item">
                                            <div class="review-item-content text-center">
                                                <?php the_content(); ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 text-center"><?php the_field('author_name') ?></div>
                                                <div class="col-lg-6 text-center"><?php the_field('author_location') ?></div>
                                            </div>
                                        </div>
                                    </div><?php

                                endwhile;

                                wp_reset_postdata();

                                the_posts_navigation(); ?>

                        </div>
                    </div>
                    <div class="review-buttons container text-center">

                        <button class="review-load-more" data-page="1" data-last-page="<?php echo $query->max_num_pages ?>">
                            <span><?php _e('Load More') ?></span>
                        </button>
                        <span class="leave-review">
                            <?php Custom_Header::mogul_review_button(); ?>
                        </span>
                    </div><?php

                    if( have_rows('additional_reviews') ): ?>
                            
                        <section class="additional-reviews container">
                            <h2 class="text-center"><?php _e('Please visit the sites below for additional reviews') ?></h2>
                            <div class="additional-reviews-list" data-post-id="<?php echo get_the_ID();?>">
                                <div class="row align-items-start"><?php
                                    $counter = 0;
                                    while ( have_rows('additional_reviews') ) : the_row(); ?>

                                        <div class="col-lg-auto additional_review_item">
                                            <a href="#" data-toggle="modal" data-target="#additionalModal" data-additional-id="<?php echo $counter ?>" >
                                                <img src="<?php the_sub_field('additional_review_logo'); ?>" alt="">
                                            </a>
                                        </div><?php
                                        $counter++;
                                    endwhile; ?>

                                </div>

                                <?php get_template_part( 'template-parts/content', 'modal' ); ?>

                            </div>
                        </section><?php

                    endif;
                    
                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
<?php

get_footer();
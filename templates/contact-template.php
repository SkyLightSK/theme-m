<?php
/**
 *
 * Template Name: Contact Form
 *
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container contact-container text-center">
                <div class="form-content">
                    <?php

                        if ( have_posts() ) {
                            while ( have_posts() ) {
                                the_post();

                                the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                                <div class="main-form"><?php

                                    the_content();?>

                                </div><?php

                            } // end while
                        } // end if

                    if (strpos($_SERVER['REQUEST_URI'], "contact") !== false) : ?>

                        <div class="hidden-form" id="form-review">
                            <?php echo do_shortcode('[contact-form-7 id="215" title="Leave a Review"]'); ?>
                        </div>
                        <div class="hidden-form" id="form-appointment">
                             <?php  echo do_shortcode('[contact-form-7 id="214" title="Book Your Appointment"]'); ?>
                        </div><?php

                    endif; ?>

                </div>

                <?php
                    if (strpos($_SERVER['REQUEST_URI'], "contact") !== false):?>
                        <div class="contact-appointment-button appointment-form-callback" data-target="#form-appointment" data-form-name="book-your-appointment">
                            <?php Custom_Header::mogul_appointment_button(); ?>
                        </div>
                        <span class="leave-review review-form-callback" data-target="#form-review" data-form-name="leave-a-review">
                            <?php Custom_Header::mogul_review_button(); ?>
                        </span><?php
                    endif
                ?>
            </div>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();

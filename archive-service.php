<?php
/**
 *
 * The template for displaying archive pages for services
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mogul
 *
 */


get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <header class="page-header services-header">
                <div class="container ">
                    <h1 class="page-title text-center"><?php echo post_type_archive_title( '', false );?></h1>

                    <?php Mogul::mogul_post_pills_nav() ?>

                </div>
            </header><!-- .page-header -->

            <!-- Show the selected services content -->

            <div class="tab-content services-wrap">

                <?php get_template_part( 'template-parts/content', get_post_type() ); ?>

            </div>
            <div class="service-examples">
                <div class="container service-examples-container">
                    <h3 class="text-center" ><?php _e('Service Examples', 'mogul'); ?></h3>
                    <div class="row">
                        <div class="col-lg-6 service-examples-left">
                            <?php Customizer::service_examples_left_list(); ?>
                        </div>
                        <div class="col-lg-6 service-examples-right">
                            <?php Customizer::service_examples_right_list(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer();
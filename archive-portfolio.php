<?php
/**
 *
 * Template Name: Portfolio
 *
 * The template for displaying archive pages for portfolio
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mogul
 *
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <!--  Show the selected portfolio content.-->
            <header class="page-header portfolio-header">
                <div class="container ">
                    <h1 class="page-title text-center"><?php echo post_type_archive_title( '', false );?></h1>

                    <?php Mogul::mogul_post_pills_nav() ?>

                </div>
            </header><!-- .page-header -->

            <div class="tab-content portfolio-gallery">

                <?php get_template_part( 'template-parts/content', get_post_type() ); ?>

            </div>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php get_footer();
<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mogul
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mogul' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

        <nav class="navbar navbar-expand-lg navbar-light bg-light ">

            <div class="nav-appointment-button">
                <?php Custom_Header::mogul_appointment_button(); ?>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <?php
                    wp_nav_menu( array(
                        'theme_location'    => 'menu-1',
                        'menu_id'           => 'primary-menu',
                        'container'         => 'div',
                        'container_id'      => 'top-navigation-primary',
                        'conatiner_class'   => 'top-navigation',
                        'menu_class'        => 'menu main-menu menu-depth-0 menu-even',
                        'echo'              => true,
                        'items_wrap'        => '<ul id="%1$s" class="navbar-nav mr-auto mt-2 mt-lg-0 ml-219 %2$s">%3$s</ul>',
                        'depth'             => 1,
                        'walker'            => new Mogul_Walker_Nav_Menu
                    ) );


                ?>

            </div>
        </nav><!-- #site-navigation -->

        <?php get_template_part( 'template-parts/header/header', 'image' ); ?>

    </header><!-- #masthead -->

	<div id="content" class="site-content">

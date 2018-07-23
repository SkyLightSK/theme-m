<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mogul
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="footer site-footer">

		<div class="site-info">
            <div class="container-fluid">
                <div class="row text-center">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-lx-4 footer-col">
                        <div class="footer-subscribe-section">
                            <?php Customizer::footer_subscribe_text(); ?>
                        </div>
                        <?php echo do_shortcode('[contact-form-7 id="66" title="Subscription Form"]'); ?>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-lx-5 footer-col footer-col-contact">
                        <div class="footer-contacts-section">
                            <?php Customizer::footer_contacts_text(); ?>
                        </div>
                        <div class="row footer-contacts justify-content-center">
                            <div class="col-auto col-md-12 col-lg-4 col-lx-4 footer-contact">
                                <span class="footer-contact-item location">
                                    <?php Customizer::mogul_footer_contacts_location(); ?>
                                </span>
                            </div>
                            <div class="col-auto col-lg-4 col-lx-4 footer-contact">
                                <span class="footer-contact-item mail">
                                    <?php Customizer::mogul_footer_contacts_mail();  ?>
                                </span>
                            </div>
                            <div class="col-auto col-lg-4 col-lx-4 footer-contact">
                                <span class="footer-contact-item phone">
                                    <?php Customizer::mogul_footer_contacts_phone(); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-lx-4 footer-col">
                        <div class="footer-socials-section">
                            <?php Customizer::footer_socials_text(); ?>
                        </div>
                        <?php
                            wp_nav_menu( array(
                                'theme_location'  => 'footer-socials',
                                'container'       => 'nav',
                                'container_class' => 'footer-socials-menu navbar navbar-expand-lg navbar-dark',
                                'menu_class'      => 'menu',
                                'echo'            => true,
                                'fallback_cb'     => 'wp_page_menu',
                                'items_wrap'      => '<ul id="%1$s" class="navbar-nav %2$s">%3$s</ul>',
                            ) );
                        ?>
                    </div>
                </div>
            </div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>


<?php
/**
 * Displays header site branding
 *
 */

?>
<div class="site-branding <?php echo is_front_page() ? 'home-branding' : ''  ?>">
    <div class="wrap">

        <?php the_custom_logo(); ?>

    </div><!-- .wrap -->
</div><!-- .site-branding -->
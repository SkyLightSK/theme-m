<?php
/**
 * Displays header media
 *
 */

?>
<div class="custom-header">

    <div class="custom-header-media <?php echo is_front_page() ? 'home-header' : '' ;  ?>">
        <?php the_custom_header_markup(); ?>
    </div>

    <?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

</div><!-- .custom-header -->
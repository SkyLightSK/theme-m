<?php
/**
 *
 * Displays gallery content
 *
*/

    if ( have_posts() ) : the_post();?>

        <div class="tab-panel"><?php

            $images = get_field('portfolio_gallery');
            $size = 'full'; // (thumbnail, medium, large, full or custom size)

            if( $images ): ?>
                <div class="container portfolio-gallery-container">
                    <div class="row "><?php

                        foreach( $images as $key => $image ): ?>

                            <div class="col text-center portfolio-gallery-col">

                                <a href="<?php echo $image['url']; ?>" data-lightbox="portfolio">
                                    <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
                                </a>

                            </div><?php

                            if (($key+1) % 5 == 0): ?>

                                <div class="col-12 p-2"></div><?php

                            endif;

                        endforeach; ?>
                    </div>
                </div><?php
            endif; ?>

        </div>
        <div class="container mogul-portfolio-content">
            <div class="content text-center">

                <?php the_content(); ?>

            </div>
        </div><?php

    else :

        get_template_part( 'template-parts/content', 'none' );

    endif;

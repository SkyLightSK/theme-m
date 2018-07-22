<?php
/**
 *
 * Template part for displaying services
 *
 */

if ( have_posts() ) : the_post();?>

    <div class="tab-panel"><?php
        //Main Items
        if( have_rows('services_items') ):?>

            <div class="container services-container">
                <div class="row "><?php

                    while ( have_rows('services_items') ) : the_row();?>
                        <div class="col-lg-4 col-xl-4 text-center service-col">
                            <h4><?php the_sub_field('service_name');?></h4>
                            <p><?php the_sub_field('service_price');?></p>
                            <p><?php the_sub_field('service_description');?></p>
                        </div><?php
                    endwhile; ?>

                </div>
            </div><?php

        endif;
        //Additional
        if( have_rows('additional') ):?>
            <div class="container">
                <section class="additional-services">
                    <h3 class="text-center">Additional</h3>
                    <div class="container additional-container">
                        <div class="row "><?php

                            while ( have_rows('additional') ) : the_row(); ?>

                                <div class="col-lg-3 col-xl-3 text-center service-col">
                                <h4><?php the_sub_field('additional_option');?></h4>
                                <p><?php the_sub_field('option_price');?></p>
                                </div><?php

                            endwhile;?>

                        </div>
                    </div>
                </section>
            </div><?php
        endif;
        //Travel
        if( have_rows('travel') ):?>
        <div class="container">
            <section class="travel-services">
                <h3 class="text-center">Travel</h3>
                <div class="container travel-container">
                    <div class="row "><?php
                    while ( have_rows('travel') ) : the_row(); ?>

                        <div class="col-lg-3 col-xl-3 text-center service-col">
                            <h4><?php the_sub_field('travel_option');?></h4>
                            <p><?php the_sub_field('option_price');?></p>
                        </div><?php

                    endwhile;?>
                    </div>
                </div>
            </section>
        </div><?php
        endif; ?>

    </div><?php

else :

    get_template_part( 'template-parts/content', 'none' );

endif;
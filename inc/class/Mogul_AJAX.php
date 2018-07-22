<?php
/**
 * Mogul AJAX calls.
 */

class Mogul_AJAX
{
    /**
     * Construct for registration mogul ajax calls
     *
     * @since	1.0.0
     */
    public function __construct()
    {
        //Wiget Category
        add_action('wp_ajax_mogul_cat_action', array( $this, 'mogul_category_action_callback' ) );
        add_action('wp_ajax_nopriv_mogul_cat_action', array( $this, 'mogul_category_action_callback' ) );

        //Nav Pills Content
        add_action('wp_ajax_mogul_post_content_action', array( $this, 'mogul_post_content_action_callback' ) );
        add_action('wp_ajax_nopriv_mogul_post_content_action', array( $this, 'mogul_post_content_action_callback' ) );

        //Reviews
        add_action('wp_ajax_mogul_reviews_action', array( $this, 'mogul_reviews_action_callback' ) );
        add_action('wp_ajax_nopriv_mogul_reviews_action', array( $this, 'mogul_reviews_action_callback' ) );


        //Additional Reviews
        add_action('wp_ajax_mogul_additional_action', array( $this, 'mogul_additional_action_callback' ) );
        add_action('wp_ajax_nopriv_mogul_additional_action', array( $this, 'mogul_additional_action_callback' ) );


        //Action Forms
        add_action('wp_ajax_mogul_contact_form_action', array( $this, 'mogul_contact_form_action_callback' ) );
        add_action('wp_ajax_nopriv_mogul_contact_form_action', array( $this, 'mogul_contact_form_action_callback' ) );

    }

    /**
     * Mogul category action callback
     *
     * @since	1.0.0
     */
    public static function mogul_category_action_callback()
    {

        $link = !empty($_POST['link']) ? esc_attr($_POST['link']) : false;

        $year = $link ? intval(wp_basename(pathinfo($link)['dirname'])) : false;
        $month = $link ? intval(wp_basename($link)) : false;

        $slug = $link ? wp_basename($link) : false;
        $cat = get_category_by_slug($slug);

        if ($year != 0 && $month != 0) {

            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'year' => $year,
                'monthnum' => $month
            );

            query_posts($args);

        } elseif (!$cat) {

            if ($slug) {

                $post_id = Mogul::get_post_id_by_slug($slug);

                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'p' => $post_id
                );

                query_posts($args);

            } else {

                die('Post ' . $slug . ' not found!');

            }

        } elseif ($cat) {

            query_posts(array(
                'posts_per_page' => get_option('posts_per_page'),
                'post_status' => 'publish',
                'category_name' => $cat->slug
            ));

        } else {

            die('Category and Id not found.');

        }

        require get_template_directory() . '/template-parts/content-posts.php';

        wp_die();
    }



    /**
     * Mogul post content action callback
     *
     * @since	1.0.0
     */
    public static function mogul_post_content_action_callback()
    {

        $post_id = !empty($_POST['postId']) ? esc_attr($_POST['postId']) : false;
        $post_type = !empty($_POST['postType']) ? esc_attr($_POST['postType']) : false;

        $args = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'p' => $post_id
        );

        query_posts($args);

        get_template_part('template-parts/content', $post_type);

        wp_die();
    }


    /**
     * Mogul reviews action callback
     *
     * @since	1.0.0
     */
    public static function mogul_reviews_action_callback()
    {

        $page_number = !empty($_POST['pageNumber']) ? esc_attr($_POST['pageNumber']) : false;

        $query = new WP_Query(array(
            'posts_per_page' => 6,
            'paged' => $page_number,
            'post_type' => 'review',
            'tax_query' => array(
                array(
                    'taxonomy' => 'review',
                    'field' => 'slug',
                    'terms' => array('portfolio', 'services'))
            )));

        /* Start the Loop */
        while ($query->have_posts()) :
            $query->the_post(); ?>

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

        wp_die();
    }


    /**
     * Mogul additional action callback
     *
     * @since	1.0.0
     */
    public static function mogul_additional_action_callback()
    {
        $additional_id = !empty($_POST['additional_id']) ? esc_attr($_POST['additional_id']) : false;
        $post_id = !empty($_POST['post_id']) ? esc_attr($_POST['post_id']) : false;
        $field = get_field('additional_reviews', $post_id)[$additional_id];

        $res = json_encode( $field );
        echo $res;

        wp_die();
    }

    /**
     * Mogul contact form action callback
     *
     * @since	1.0.0
     */
    public static function mogul_contact_form_action_callback()
    {

        $form_slug = !empty($_POST['form_slug']) ? esc_attr($_POST['form_slug']) : false;

        $query = new WP_Query(array(
            'pagename' => $form_slug
        ));

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                the_title();

            } // end while
        } // end if
        wp_reset_postdata();

        wp_die();
    }

}
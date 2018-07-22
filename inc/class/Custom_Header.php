<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Mogul
 */

class Custom_Header
{

    /**
     * Construct settings for custom header
     *
     * @since	1.0.0
     */
    public function __construct()
    {
        add_action('customize_register', array( $this,'mogul_header_customize_register' ) );
        add_action('after_setup_theme', array( $this,'mogul_custom_header_setup' ) );
    }

    /**
     * Add postMessage support for site header for the Theme Customizer.
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
    public function mogul_header_customize_register($wp_customize)
    {
        if (isset($wp_customize->selective_refresh)) {

            $wp_customize->selective_refresh->add_partial('mogul-header-appointment-image', array(
                'selector' => '.nav-appointment-button, .contact-appointment-button ',
                'render_callback' => 'mogul_appointment_button',
            ));

            // Review image
            $wp_customize->selective_refresh->add_partial('mogul-review-image', array(
                'selector' => '.leave-review',
                'render_callback' => 'mogul_review_button',
            ));

        }

        $wp_customize->add_setting('mogul-header-appointment-image', array(
            'priority' => 1,
            'default' => true,
            'transport' => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'mogul-header-appointment-image-control', array(
            'label' => __('Appointment button image', 'mogul'),
            'priority' => 1,
            'section' => 'header_image',
            'settings' => 'mogul-header-appointment-image',
        )));

        // Review setting and control
        $wp_customize->add_setting('mogul-review-image', array(
            'priority' => 1,
            'default' => true,
            'transport' => 'refresh',
        ));

        $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'mogul-review-image-control', array(
            'label' => __('Review button image', 'mogul'),
            'priority' => 1,
            'section' => 'header_image',
            'settings' => 'mogul-review-image',
        )));

    }


    /**
     * Render the appointment image for the selective refresh partial.
     *
     * @return void
     */
    public static function mogul_appointment_button()
    { ?>

    <a href="<?php echo get_permalink(get_page_by_path('book-your-appointment')); ?>" rel="appointment">
        <img src="<?php echo wp_get_attachment_image_url(get_theme_mod('mogul-header-appointment-image')); ?>" alt="">
        </a><?

    }

    /**
     * Render the appointment image for the selective refresh partial.
     *
     * @return void
     */
    public static function mogul_review_button()
    { ?>

    <a href="<?php echo get_permalink(get_page_by_path('leave-a-review')); ?>" rel="review">
        <img src="<?php echo wp_get_attachment_image_url(get_theme_mod('mogul-review-image')); ?>" alt="">
    </a><?

    }

    /**
     * Set up the WordPress core custom header feature.
     *
     */
    public function mogul_custom_header_setup()
    {
        add_theme_support('custom-header', apply_filters('mogul_custom_header_args', array(
            'default-image' => get_parent_theme_file_uri('/assets/images/banner-layer.png'),
            'default-text-color' => '000000',
            'width' => 1920,
            'height' => 620,
            'flex-height' => true,
            'wp-head-callback' => function () {
                /**
                 * Styles the header image and text displayed on the blog.
                 *
                 * @see mogul_custom_header_setup().
                 */
                $header_text_color = get_header_textcolor();

                /*
                 * If no custom options for text are set, let's bail.
                 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
                 */
                if (get_theme_support('custom-header', 'default-text-color') === $header_text_color) {
                    return;
                }

                // If we get this far, we have custom styles. Let's do this.
                ?>
                <style type="text/css">
                    <?php
                    // Has the text been hidden?
                    if ( ! display_header_text() ) :
                        ?>
                    .site-title,
                    .site-description {
                        position: absolute;
                        clip: rect(1px, 1px, 1px, 1px);
                    }

                    <?php
                    // If the user has set a custom color for the text use that.
                    else :
                        ?>
                    .site-title a,
                    .site-description {
                        color: #<?php echo esc_attr( $header_text_color ); ?>;
                    }

                    <?php endif; ?>
                </style>
                <?php
            },
                //$this->mogul_header_style(),
        )));

    }

}
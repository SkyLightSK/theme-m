<?php
/**
 * Enqueue scripts and styles.
 */

class Enqueue
{
    /**
     * Construct Enqueue scripts and styles
     *
     * @since	1.0.0
     */
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'mogul_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );

    }

    /**
     * Function for registration frontend scripts and styles
     *
     * @since	1.0.0
     */
    public function mogul_scripts()
    {

        //  Style
        wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css', array() ,'4.1.1' );

        wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css', array() ,'5.0.13' );

        wp_enqueue_style( 'lightbox-css',  get_template_directory_uri() . '/assets/lightbox2-master/dist/css/lightbox.css' , array() ,'2.0.0' );

        wp_enqueue_style( 'mogul-style', get_stylesheet_uri() );

        //  Scripts
        wp_enqueue_script( 'bootstrapcdn', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array(), '4.1.1', true );

        wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), '4.1.1', true );

        wp_enqueue_script( 'lightbox-js',  get_template_directory_uri() . '/assets/lightbox2-master/dist/js/lightbox.js' , array(), '2.0.0', true );

        wp_enqueue_script( 'cloudflare', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array(), '4.1.1', true );



        wp_enqueue_script( 'mogul-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

        wp_enqueue_script( 'mogul-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_enqueue_script( 'mogul-ajax',  get_template_directory_uri() . '/js/mogul-ajax.js', array( 'jquery' ), '1.0.0', true );

        wp_localize_script( 'mogul-ajax', 'ajax',
            array(
                'url' => admin_url('admin-ajax.php')
            )
        );
    }

    /**
     * Function for registration admin scripts and styles
     *
     * @since	1.0.0
     */
    function load_admin_style() {

        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/layouts/admin-style.css', false, '1.0.0' );
        wp_enqueue_script( 'admin-scripts', get_template_directory_uri() . '/js/admin-scripts.js', array( 'jquery' )  );

    }

}

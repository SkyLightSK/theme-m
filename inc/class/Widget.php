<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

class Widget
{
    /**
     * Construct widgets
     *
     * @since	1.0.0
     */
    public function __construct()
    {
        add_action( 'widgets_init', array( $this, 'mogul_widgets_init' ) );
    }

    /**
     * Widgets init function
     *
     * @since	1.0.0
     */
    public function mogul_widgets_init()
    {
        register_sidebar( array(
            'name'          => esc_html__( 'Sidebar', 'mogul' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'mogul' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }

}
<?php
/**
     * Mogul Theme Customizer
     *
     * @package Mogul
     */

//require_once 'WP_Editor_Customize_Control.php';
require_once get_template_directory() . '/inc/WP_Editor_Customize_Control.php';

class Customizer
{
    /**
     * Construct customizer registrations
     *
     * @since	1.0.0
     */
    public function __construct()
    {
        add_action( 'customize_register', array( $this, 'mogul_customize_register' ) );
        add_action( 'customize_preview_init', array( $this, 'mogul_customize_preview_js' ) );

    }

    /**
     * Add postMessage support for site title and description for the Theme Customizer.
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
    public static function mogul_customize_register( $wp_customize )
    {

        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

        if ( isset( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial( 'blogname', array(
                'selector'        => '.site-title a',
                'render_callback' => 'mogul_customize_partial_blogname',
            ) );
            $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
                'selector'        => '.site-description',
                'render_callback' => 'mogul_customize_partial_blogdescription',
            ) );

            //Services
            $wp_customize->selective_refresh->add_partial( 'services-example-left-list', array(
                'selector'        => '.service-examples-left',
                'render_callback' => 'service_examples_left_list',
            ) );
            $wp_customize->selective_refresh->add_partial( 'services-example-right-list', array(
                'selector'        => '.service-examples-right',
                'render_callback' => 'service_examples_right_list',
            ) );

            //footer
            $wp_customize->selective_refresh->add_partial( 'footer_subscribe_text_layout', array(
                'selector'        => '.footer-subscribe-section',
                'render_callback' => 'footer_subscribe_text',
            ) );
            $wp_customize->selective_refresh->add_partial( 'footer_contacts_text_layout', array(
                'selector'        => '.footer-contacts-section',
                'render_callback' => 'footer_contacts_text',
            ) );
            $wp_customize->selective_refresh->add_partial( 'footer_contacts_location_settings', array(
                'selector'        => '.footer-contact.location',
                'render_callback' => 'mogul_footer_contacts_location',
            ) );
            $wp_customize->selective_refresh->add_partial( 'footer_contacts_mail_settings', array(
                'selector'        => '.footer-contact.mail',
                'render_callback' => 'mogul_footer_contacts_mail',
            ) );
            $wp_customize->selective_refresh->add_partial( 'footer_contacts_phone_settings', array(
                'selector'        => '.footer-contact.phone',
                'render_callback' => 'mogul_footer_contacts_phone',
            ) );
            $wp_customize->selective_refresh->add_partial( 'footer_socials_text_layout', array(
                'selector'        => '.footer-socials-section',
                'render_callback' => 'footer_socials_text',
            ) );

        }

        /**
         * Footer options.
         */

        $wp_customize->add_panel('footer_panel',array(
            'title'=>'Footer',
            'description'=> 'Footer settings',
            'priority'=> 130, // Before Additional CSS.
        ));

        $wp_customize->add_section( 'footer_subscribe', array(
            'title'    => __( 'Footer Subscribe Section', 'mogul' ),
            'priority' => 10,
            'panel'    => 'footer_panel'
        ) );

        $wp_customize->add_setting( 'footer_subscribe_text_layout', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Editor_Customize_Control($wp_customize, 'footer_subscribe_text_layout', array(
            'label' => __( 'Text editor', 'mogul' ),
            'priority' => 1,
            'section' => 'footer_subscribe',
            'editor_settings' => array(
                'quicktags' => true,
                'tinymce'   =>  array(
                    'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                    'toolbar2' => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                )
            ),
        )));

        $wp_customize->add_section( 'footer_contacts', array(
            'title'    => __( 'Footer Contacts Section', 'mogul' ),
            'priority' => 10,
            'panel'    => 'footer_panel'
        ) );

        //Settings
        $wp_customize->add_setting( 'footer_contacts_text_layout', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_setting( 'footer_contacts_location_settings', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_setting( 'footer_contacts_mail_settings', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_setting( 'footer_contacts_phone_settings', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Editor_Customize_Control($wp_customize, 'footer_contacts_text_layout', array(
            'label' => __( 'Text editor', 'mogul' ),
            'priority' => 1,
            'section' => 'footer_contacts',
            'editor_settings' => array(
                'quicktags' => true,
                'tinymce'   =>  array(
                    'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                    'toolbar2' => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                )
            ),
        )));

        $wp_customize->add_control(
            'footer_contacts_location',
            array(
                'label'    => __( 'Location', 'mytheme' ),
                'section'  => 'footer_contacts',
                'settings' => 'footer_contacts_location_settings',
                'type'     => 'text'
            )
        );
        $wp_customize->add_control(
            'footer_contacts_email',
            array(
                'label'    => __( 'Email', 'mytheme' ),
                'section'  => 'footer_contacts',
                'settings' => 'footer_contacts_mail_settings',
                'type'     => 'email'
            )
        );
        $wp_customize->add_control(
            'footer_contacts_phone',
            array(
                'label'    => __( 'Phone', 'mytheme' ),
                'section'  => 'footer_contacts',
                'settings' => 'footer_contacts_phone_settings',
                'type'     => 'tel',
            )
        );

        $wp_customize->add_section( 'footer_socials', array(
            'title'    => __( 'Footer Socials Section', 'mogul' ),
            'priority' => 10,
            'panel'    => 'footer_panel'
        ) );

        $wp_customize->add_setting( 'footer_socials_text_layout', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Editor_Customize_Control($wp_customize, 'footer_socials_text_layout', array(
            'label' => __( 'Text editor', 'mogul' ),
            'priority' => 1,
            'section' => 'footer_socials',
            'editor_settings' => array(
                'quicktags' => true,
                'tinymce'   =>  array(
                    'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                    'toolbar2' => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                )
            ),
        )));

        /**
         *
         * Services Section
         *
         */
        $wp_customize->add_section( 'services', array(
            'title'    => __( 'Services Page', 'mogul' ),
            'priority' => 120
        ) );

        //Settings
        $wp_customize->add_setting( 'services-example-left-list', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_setting( 'services-example-right-list', array(
            'default'           => 'Edit here',
            'transport'         => 'postMessage',
        ) );

        //Controls
        $wp_customize->add_control( new WP_Editor_Customize_Control($wp_customize, 'services-example-left-list', array(
            'label' => __( 'Services Example Left Column', 'mogul' ),
            'priority' => 1,
            'section' => 'services',
            'editor_settings' => array(
                'quicktags' => true,
                'tinymce'   =>  array(
                    'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                    'toolbar2' => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                )
            ),
        )));
        $wp_customize->add_control( new WP_Editor_Customize_Control($wp_customize, 'services-example-right-list', array(
            'label' => __( 'Services Example Right Column', 'mogul' ),
            'priority' => 1,
            'section' => 'services',
            'editor_settings' => array(
                'quicktags' => true,
                'tinymce'   =>  array(
                    'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                    'toolbar2' => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                )
            ),
        )));

    }


    /**
     * Render the site title for the selective refresh partial.
     *
     * @return void
     */
    public static function mogul_customize_partial_blogname()
    {
        bloginfo( 'name' );
    }


    /**
     * Footer functions
     *
     * @return void
     */

    /**
     * Subscribe
     *
     * @return void
     */
    public static function footer_subscribe_text()
    {
        if(get_theme_mod('footer_subscribe_text_layout')):
            echo get_theme_mod('footer_subscribe_text_layout');
        endif;
    }

    /**
     * Contacts
     *
     * @return void
     */
    public static function footer_contacts_text()
    {
        if(get_theme_mod('footer_contacts_text_layout')):
            echo get_theme_mod('footer_contacts_text_layout');
        endif;
    }
    public static function mogul_footer_contacts_location()
    {
        if(get_theme_mod('footer_contacts_location_settings')):
            echo get_theme_mod('footer_contacts_location_settings');
        endif;
    }
    public static function mogul_footer_contacts_mail()
    {
        if(get_theme_mod('footer_contacts_mail_settings')):?>
            <a href="mailto:<?php echo get_theme_mod('footer_contacts_mail_settings'); ?>"><?php echo get_theme_mod('footer_contacts_mail_settings'); ?></a><?
        endif;
    }
    public static function mogul_footer_contacts_phone()
    {
        if(get_theme_mod('footer_contacts_phone_settings')):?>
            <a href="tel:<?php echo get_theme_mod('footer_contacts_phone_settings'); ?>"><?php echo get_theme_mod('footer_contacts_phone_settings'); ?></a><?
        endif;
    }

    /**
     * Socials
     *
     * @return void
     */
    public static function footer_socials_text()
    {
        if(get_theme_mod('footer_socials_text_layout')):
            echo get_theme_mod('footer_socials_text_layout');
        endif;
    }

    /**
     * Services
     *
     * @return void
     */
    public static function service_examples_left_list()
    {
        if(get_theme_mod('services-example-left-list')):
            echo get_theme_mod('services-example-left-list');
        endif;
    }
    public static function service_examples_right_list()
    {
        if(get_theme_mod('services-example-right-list')):
            echo get_theme_mod('services-example-right-list');
        endif;
    }

    public static function mogul_customize_partial_blogdescription()
    {
        bloginfo( 'description' );
    }

    /**
     * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
     */
    public static function mogul_customize_preview_js()
    {
        wp_enqueue_script( 'mogul-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
    }

}
<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Product
{
    /**
     * The text domain of the post type
     *
     * @param 	string
     * @since 	1.0.0
     */
    protected $textdomain;

    /**
     *  Posts of post type
     *
     * @param 	array
     * @since 	1.0.0
     */
    protected $posts;

    /**
     *  Post type slug
     *
     * @param 	string
     * @since 	1.0.0
     */
    protected $post_type;

    /**
     * Make a new post type setup
     *
     * @param 	string	         $type				        Slug of new post type
     * @param 	string	         $singular_label			Singular label of new post type
     * @param 	string	         $plural_label				Plural label of new post type
     * @param 	string	         $menu_icon				    Menu icon of new post type
     *                                                      (string of dashicon or link to image)
     * @param   (string|array)   $settings                  Custom post type settings
     *
     * @since	1.0.0
     */
    public function make( $type, $singular_label, $plural_label, $menu_icon, $settings = array() )
    {

        $this->post_type = $type;

        // Define the default settings
        $default_settings = array(
            'labels' => array(
                'name' => __($plural_label, $this->textdomain),
                'singular_name' => __($singular_label, $this->textdomain),
                'add_new_item' => sprintf( __( 'Add New %s', $this->textdomain ), $singular_label ),
                'edit_item' => sprintf( __( 'Edit %s', $this->textdomain ), $singular_label ),
                'new_item' => sprintf( __( 'New %s', $this->textdomain ), $singular_label ),
                'view_item' => sprintf( __( 'View %s', $this->textdomain ), $singular_label ),
                'search_items' => sprintf( __( 'Search %s', $this->textdomain ), $plural_label ),
                'not_found' => sprintf( __( 'No %s found', $this->textdomain ), $plural_label ),
                'not_found_in_trash' => sprintf( __( 'No %s found in trash', $this->textdomain ), $plural_label ),
                'parent_item_colon' => sprintf( __( 'Parent %s', $this->textdomain ), $singular_label ),
            ),
            'public'=>true,
            'has_archive' => true,
            'menu_position'=>20,
            'menu_icon'=> $menu_icon,
            'supports'=>array(
                'title',
                'editor',
                'thumbnail'
            ),
            'rewrite' => array(
                'slug' => sanitize_title_with_dashes($plural_label)
            ),
            'register_meta_box_cb' => function() {
                add_meta_box(
                    'price_location',
                    'Price',
                    [self::class, 'price_location'],
                    $this->post_type,
                    'side',
                    'default'
                );
                add_meta_box(
                    'availability_location',
                    'Availability',
                    [self::class, 'availability_location'],
                    $this->post_type,
                    'side',
                    'default'
                );
                add_meta_box(
                    'gallery_location',
                    'Gallery',
                    [self::class, 'gallery_location'],
                    $this->post_type,
                    'normal',
                    'default'
                );
            },
        );
        // Override any settings provided by user
        // and store the settings with the posts array
        $this->posts[$type] = array_merge($default_settings, $settings);
    }

    /**
     * Construct a new instance
     *
     * @param 	string 	$textdomain	The new custom product post type domain name
     *
     * @since	1.0.0
     */
    public function __construct( $textdomain )
    {
        // Initialize text domain
        $this->textdomain = $textdomain;

        // Initialize the posts array
        $this->posts = array();
        // Add the action hook calling the register_custom_post method
        add_action('init', array(&$this, 'register_custom_post'));
        // Add the action hook that saving meta for post type
        add_action( 'save_post', [ 'Product' , 'save_events_meta' ], 1, 2 );


    }

    /**
     * Register custom posts
     *
     * @since	1.0.0
     */
    public function register_custom_post()
    {
        // Loop through the registered posts
        // and register all posts stored in the array
        foreach($this->posts as $key=>$value) {
            register_post_type($key, $value);
        }
    }

    /**
     * Price metabox location
     *
     * @since	1.0.0
     */
    public static function price_location() {
        global $post;
        // Nonce field to validate form request came from current site
        wp_nonce_field( basename( __FILE__ ), 'price_field' );
        // Get the location data if it's already been entered
        $price = get_post_meta( $post->ID, 'price', true );
        // Output the field
        echo '<input type="text" name="price" value="' . esc_textarea( $price )  . '" class="widefat">';
    }

    /**
     * Availability metabox location
     *
     * @since	1.0.0
     */
    public static function availability_location() {
        global $post;
        // Nonce field to validate form request came from current site
        wp_nonce_field( basename( __FILE__ ), 'availability_field' );
        // Get the location data if it's already been entered
        $location = get_post_meta( $post->ID, 'availability', true );
        // Output the field
        ?>
            <!-- Rounded switch -->
            <label class="switch" >
                <input id="availability-checkbox" type="checkbox" name="availability" <?php echo ( $location == 'true' ) ? esc_attr( 'checked' ) : esc_attr( '' ) ?>
                       value="<?php _e( $location ) ; ?>">
                <span class="slider round"></span>
            </label>
        <?php
    }

    /**
     * Gallery metabox location
     *
     * @since	1.0.0
     */
    public static function gallery_location() {
        global $post;
        // Nonce field to validate form request came from current site
        wp_nonce_field( basename( __FILE__ ), 'gallery_field' );

        // Begin the field table and loop
        echo '<table class="form-table">';
            // get value of this field if it exists for this post
            $meta = get_post_meta($post->ID, 'gallery' , true);
            // begin a table row with
            echo '<tr>
                <td>';

                    $meta_html = null;
                    if ($meta) {
                        $meta_html .= '<ul class="mogul_product_gallery_list">';
                        $meta_array = explode(',', $meta);
                        foreach ($meta_array as $meta_gall_item) {
                            $meta_html .= '<li><div class="mogul_product_gallery_container"><span class="mogul_product_gallery_close"><img id="' . esc_attr($meta_gall_item) . '" src="' . wp_get_attachment_thumb_url($meta_gall_item) . '"></span></div></li>';
                        }
                        $meta_html .= '</ul>';
                    }
                    echo '<input id="mogul_product_gallery" type="hidden" name="gallery" value="' . esc_attr($meta) . '" />
                        <span id="mogul_product_gallery_src">' . $meta_html . '</span>
                        <div class="mogul_gallery_button_container "><input id="mogul_product_gallery_button" class="button button-primary" type="button" value="Add Gallery" /></div>';

            echo '</td></tr>';

        echo '</table>'; // end table
    }

    /**
     * Save the metabox data
     *
     * @param 	int	     $post_id		ID of post type
     * @param 	object	 $post			Post object
     *
     * @since	1.0.0
     */
    public function save_events_meta($post_id, $post )
    {
        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        // Verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times.
        if ( ! isset( $_POST['price'] ) || ! wp_verify_nonce( $_POST['price_field'], basename(__FILE__) ) ) {
            return $post_id;
        }
        if ( ! isset( $_POST['availability'] ) || ! wp_verify_nonce( $_POST['availability_field'], basename(__FILE__) ) ) {
            return $post_id;
        }
        if ( ! isset( $_POST['gallery'] ) || ! wp_verify_nonce( $_POST['gallery_field'], basename(__FILE__) ) ) {
            return $post_id;
        }
        // Now that we're authenticated, time to save the data.
        // This sanitizes the data from the field and saves it into an array $events_meta.
        $events_meta['price'] = esc_textarea( $_POST['price'] );
        $events_meta['availability'] = esc_textarea( $_POST['availability'] );
        $events_meta['gallery'] = esc_textarea( $_POST['gallery'] );

        // Cycle through the $events_meta array.
        // Note, in this example we just have one item, but this is helpful if you have multiple.
        foreach ( $events_meta as $key => $value ) :
            // Don't store custom data twice
            if ( 'revision' === $post->post_type ) {
                return;
            }
            if ( get_post_meta( $post_id, $key, false ) ) {
                // If the custom field already has a value, update it.
                update_post_meta( $post_id, $key, $value );
            } else {
                // If the custom field doesn't have a value, add it.
                add_post_meta( $post_id, $key, $value);
            }
            if ( ! $value ) {
                // Delete the meta key if there's no value
                delete_post_meta( $post_id, $key );
            }
        endforeach;
    }


}
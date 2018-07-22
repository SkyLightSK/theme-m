<?php

require_once 'Post_Type_Interface.php';

/**
 * Acts as a faux-extension for WP_Post that includes custom fields. While it is impossible to actually extend
 * WP_Post, we are essentially doing that in an unofficial capacity, in a way that can be re-worked
 * and extended for various use cases.
 *
 * Basic usage is as follows:
 *
 * 	- Extend a single post using the post ID, an array, or a WP_Post object
 *
 *		$post = new Product_Post( $my_post_id );
 *		echo $post->fields['first_name'];
 *
 * 	- Get multiple post extension objects using the static get() or get_by() methods
 *
 * 		a. Use the get() method as a wrapper for our post extension object via WP_Query
 *
 * 			$posts = Product_Post::get( $my_wp_query_args );
 *
 * 		b. Use the get_by() method to get posts by field value(s). In addition to the usual
 * 		   WP_Query arguments, we can use our custom `fields` and `fields_relation` keys instead
 * 		   of mucking around with $args['meta_query']
 *
 *			$posts = Product_Post::get_by( array(
 *
 *				'post_type'	=> 'my_post_type',
 *				'fields'	=> array(
 *					'my_key_1'	=> 'my_value_1',
 *					'my_key_2'	=> array( 'my_value_2', 'my_value_3' ),
 * 				),
 *				'fields_relation' => 'AND',
 *			) );
 *
 * @link	https://codex.wordpress.org/Class_Reference/WP_Post
 * @link 	https://developer.wordpress.org/reference/functions/get_post
 *
 * @link 	https://codex.wordpress.org/Custom_Fields
 * @link 	https://developer.wordpress.org/reference/functions/get_post_meta
 * @link 	https://codex.wordpress.org/Function_Reference/add_post_meta
 * @link 	https://developer.wordpress.org/reference/functions/update_post_meta
 * @link 	https://developer.wordpress.org/reference/functions/delete_post_meta
 *
 * @since 	1.0.0
 */

/**
 * A Product_Post.
 */

class Product_Post implements Post_Type_Interface
{

    /**
     * The post object that we're 'extending'
     *
     * @link	https://codex.wordpress.org/Class_Reference/WP_Post
     *
     * @param 	WP_Post
     * @since 	1.0.0
     */
    public $post;
    /**
     * The ID of the post
     *
     * @param 	int
     * @since 	1.0.0
     */
    public $ID = 0;
    /**
     * The post type for the post
     *
     * @link 	https://codex.wordpress.org/Post_Types
     *
     * @param 	string
     * @since 	1.0.0
     */
    public $post_type = '';
    /**
     * The post meta, (i.e. custom fields) for the post, if any have been loaded
     *
     * An option exists in __construct() to disable postmeta from being loaded automatically when creating
     * a new object (for better control over DB performance)
     *
     * @link 	https://codex.wordpress.org/Custom_Fields
     * @see		$this->get_post_meta()
     *
     * @param 	array
     * @since 	1.0.0
     */
    public $fields;
    /**
     * Class methods
     *
     * - __construct()
     * - get_post_meta()
     * - get()
     * - get_by()
     */

    /**
     * Construct a new instance
     *
     * @param 	(int|string|array|WP_Post) 	$args	The ID or WP_Post we are extending, or an array with
     *												data to get the post
     *
     * @param 	bool	$autoload_post				Whether to automatically get the WP_Post if $args is not a WP_Post
     * @param 	bool 	$autoload_post_meta			Whether to automatically load custom fields for the post
     *
     * @since	1.0.0
     */
    function __construct( $args, $autoload_post = true, $autoload_post_meta = true )
    {
        # if we're passed a WP_Post object
        if( is_a( $args, 'WP_Post' ) )
        {
            $this->post = $args;
            $this->ID = $this->post->ID;
        } # end if: $args is an WP_Post

        /**
         * If we're given an array, load the array values into $this->ID, $this->post_type, $this->fields as needed
         * Get the WP_Post using $args['ID'] given and $autoload_post is true
         */
        elseif( is_array( $args ) )
        {
            $this->fields = array();
            foreach( $args as $k => $v ) {
                # if we have in ID in $args
                if( 'ID' == $k )
                {
                    if( ! is_string( $v ) && ! is_int( $v ) ) continue;
                    $this->ID = intval( $v );

                    # load the post if applicable
                    if( $autoload_post && $this->ID ) $this->post = get_post( $this->ID );
                }
                elseif( 'post_type' == $k )
                {
                    $this->post_type = $v;
                }
                # treat everything else as a custom field
                else
                {
                    $this->fields[ $k ] = $v;
                }
            } # end foreach: $args
        } # end elseif: $args is an array

        # if we're given an int or a string
        elseif( is_int( $args ) || is_string( $args ) )
        {
            $this->ID = intval( $args );

            if( $autoload_post )
            {
                $this->post = get_post( $this->ID );
            }
        }

        # if we don't have an ID at this point, do nothing further
        if( ! $this->ID ) return;

        # load the custom fields for the post
        # Adds to any fields that may already have been loaded via $args
        if( $autoload_post_meta ) {
            $this->get_post_meta( true );
        }

        # if we don't have a post at this point, do nothing further
        if( ! $this->post )	return;

        # load the post type
        $this->post_type = $this->post->post_type;

    } # end: construct()

    /**
     * Set/get the post meta for this object
     *
     * The $force parameter is in place to prevent hitting the database each time the method is called
     * when we already have what we need in $this->fields
     *
     * @link 	https://developer.wordpress.org/reference/functions/get_post_meta
     *
     * @param 	$force 		Whether to force load the post meta (helpful if $this->fields is already an array).
     *
     * @return 	array
     * @since 	1.0.0
     */
    function get_post_meta( $force = false )
    {
        # make sure we have an ID
        if( ! $this->ID ) return array();

        # if $this->fields is already an array
        if( is_array( $this->fields ) )
        {

            # return the array if we're not forcing the post meta to load
            if( ! $force ) return $this->fields;

        }

        # if $this->fields isn't an array yet, initialize it as one
        else $this->fields = array();

        # get all post meta for the post
        $fields = get_post_meta( $this->ID );

        # if we found nothing
        if( ! $fields )
        {
            return $this->fields;
        }

        # loop through and clean up singleton arrays
        foreach( $fields as $k => $v )
        {
            # need to grab the first item if it's a single value
            if( count( $v ) == 1 )

                $this->fields[ $k ] = maybe_unserialize( $v[0] );

            # or store them all if there are multiple
            else $this->fields[ $k ] = $v;

        }

        return $this->fields;
    } # end: get_post_meta()

    /**
     * Get an array of new instances of this class (or an extension class), as a wrapper for a new WP_Query
     *
     * @param 	array 	$wp_query_args 			Arguments to use for the WP_Query
     * @param 	bool	$autoload_post			Used when constructing the class instance
     * @param 	bool	$autoload_post_meta		Used when constructing the class instance
     *
     * @return 	array
     * @since 	1.0.0
     */
    public static function get( $wp_query_args, $autoload_post = true, $autoload_post_meta = true )
    {
        # default arguments
        $defaults = array(
            'posts_per_page' => -1
        );

        # load default args
        $wp_query_args = wp_parse_args( $wp_query_args, $defaults );
        $query = new WP_Query( $wp_query_args );
        $out = array();

        foreach( $query->posts as $post )
        {

            /**
             * Note that $autoload_post here is forced to be false, since we know we have
             * a WP_Post in this case.
             *
             * This isn't totally necessary, but it's safe in case __construct() ever changes
             * and somehow looks for this value
             */
            $out[] = new static( $post, false, $autoload_post_meta );

        }
        return $out;
    } # end: get()

    /**
     * Get an array of new instances of this class (or an extension class) by field value or values
     *
     * This method allows us to get posts via WP_Query, while also passing in key/value pairs and a 'fields_relation'
     * argument to the same array
     *
     * The net effect is that we can easily get extended posts, complete with postmeta, by field keys in a way
     * that allows any arguments necessary from WP_Query
     *
     * If more control is needed over the meta_query item, you can
     *
     * 		- use self::get() (a more basic wrapper for WP_Query) and pass in the meta_query manually
     * 		- use the 'hphp_get_posts_by' hook to access the query arguments
     *		- use a normal WP_Query or get_posts; and then for each $post, create a new Product_Post( $post )
     *
     * @param	array 	$args 	{
     *
     *		Arguments for getting posts.  Besides the keys given, any arguments for WP_Query can also be included.
     *
     *		'fields_relation'
     *		'fields' => array(
     *			'meta_key_1' => 'value1',
     *			'meta_key_2' => array( 'value2', 'value3' ),
     *			...
     *		)
     *	}
     *
     * @param 	bool	$autoload_post			Used when constructing the class instance
     * @param 	bool	$autoload_post_meta		Used when constructing the class instance
     *
     * @return 	array
     * @since 	1.0.0
     */
    public static function get_by( $args, $autoload_post = true, $autoload_post_meta = true )
    {
        # default arguments
        $defaults = array(
            'posts_per_page' => -1,
            'fields_relation' => 'OR',
        );

        # load default args
        $args = wp_parse_args( $args, $defaults );

        # load the meta query
        ## get key/value pairs from $args
        $meta_query = array();
        if( ! empty( $args['fields'] ) )

            foreach( $args['fields'] as $k => $v )
            {
                # if the key is not in our default array, we'll consider it a post meta key
                if( ! in_array( $k, array_keys( $defaults ) ) )
                {

                    # the new item we'll add to meta_query
                    $new_meta_query_item = array( 'key' => $k, 'value' => $v );

                    # if we have an array of values
                    if( is_array( $v ) ) $new_meta_query_item[ 'compare' ] = 'IN';
                    else $new_meta_query_item[ 'compare' ] = '=';
                    $meta_query[] = $new_meta_query_item;

                }
            } # end foreach: $args['fields']

        unset( $args['fields'] );
        ## if keys were given, add the meta query to the wp query args

        if( ! empty( $meta_query ) )
        {

            $meta_query['relation'] = $args['fields_relation'];
            $args['meta_query'] = $meta_query;

        }
        unset( $args['fields_relation'] );
        return static::get( $args, $autoload_post, $autoload_post_meta );
    } # get_by()

    /**
     * Get an array of price post meta.
     *
     * @return 	array
     * @since 	1.0.0
     */
    public function getPrice()
    {
        return get_post_meta( $this->ID, 'price', true );
    }

    /**
     * Get an array of availability post meta.
     *
     * @return 	array
     * @since 	1.0.0
     */
    public function isInStock()
    {
        return get_post_meta( $this->ID, 'availability', true );
    }

    /**
     * Get an array of gallery post meta.
     *
     * @return 	array
     * @since 	1.0.0
     */
    public function getGallery()
    {
        return get_post_meta( $this->ID, 'gallery', true );
    }

} # end class: Product_Post

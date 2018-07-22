<?php

class Mogul
{
    /**
     * Construct Mogul functions
     *
     * @since	1.0.0
     */
    public function __construct()
    {
        add_filter( 'body_class', array( $this, 'mogul_body_classes' ) );
        add_action( 'wp_head', array( $this, 'mogul_pingback_header' ) );
    }

    /**================================================================
     * Functions which enhance the theme by hooking into WordPress
     *
     * @package Mogul
     *================================================================/

    /**
     * Adds custom classes to the array of body classes.
     *
     * @param array $classes Classes for the body element.
     * @return array
     */
    public function mogul_body_classes( $classes )
    {
        // Adds a class of hfeed to non-singular pages.
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }

        // Adds a class of no-sidebar when there is no sidebar present.
        if ( ! is_active_sidebar( 'sidebar-1' ) ) {
            $classes[] = 'no-sidebar';
        }

        return $classes;
    }

    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     */
    public function mogul_pingback_header()
    {
        if ( is_singular() && pings_open() ) {
            echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
        }
    }

    /**
     * Get post id by slug name.
     */
    public static function get_post_id_by_slug( $slug, $post_type = "post" )
    {
        $query = new WP_Query(
            array(
                'name'   => $slug,
                'post_type'   => $post_type,
                'numberposts' => 1,
                'fields'      => 'ids',
            ) );
        $posts = $query->get_posts();
        return array_shift( $posts );
    }

    /**=====================================
     * Custom template tags for this theme
     *
     * Eventually, some of the functionality here could be replaced by core features.
     *
     * @package Mogul
     *=======================================/


    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    public static function mogul_posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = sprintf(
        /* translators: %s: post date. */
            esc_html_x( 'Posted on %s', 'post date', 'mogul' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

    }

    /**
     * Prints HTML with meta information for the current author.
     */
    public static function mogul_posted_by()
    {
        $byline = sprintf(
        /* translators: %s: post author. */
            esc_html_x( 'by %s', 'post author', 'mogul' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

    }

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    public static function mogul_entry_footer()
    {
        // Hide category and tag text for pages.
        if ( 'post' === get_post_type() ) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( esc_html__( ', ', 'mogul' ) );
            if ( $categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mogul' ) . '</span>', $categories_list ); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mogul' ) );
            if ( $tags_list ) {
                /* translators: 1: list of tags. */
                printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mogul' ) . '</span>', $tags_list ); // WPCS: XSS OK.
            }
        }

        if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: post title */
                        __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mogul' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Edit <span class="screen-reader-text">%s</span>', 'mogul' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }

    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    public static function mogul_post_thumbnail()
    {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
                <?php
                the_post_thumbnail( 'post-thumbnail', array(
                    'alt' => the_title_attribute( array(
                        'echo' => false,
                    ) ),
                ) );
                ?>
            </a>

        <?php
        endif; // End is_singular().
    }

    /**
     * Prints Pills Nav for post titles.
     */
    public static function mogul_post_pills_nav()
    {
        if ( have_posts() ) :?>

            <ul class="nav mogul-nav-pills justify-content-center"><?php

            while ( have_posts() ) : the_post();?>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-id="<?php echo get_the_ID(); ?>" data-post-type="<?php echo get_post_type(); ?>" >
                        <?php the_title(); ?>
                    </a>
                </li><?
            endwhile; ?>

            </ul><?

        endif;
    }

}

<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mogul
 */


get_header();

$field = trim($_GET['field']);
$page = (get_query_var('page')) ? trim(get_query_var('page')) : 1;

?>
    <header class="entry-header text-center">
        <h1><?php _e('I`m getting fields') ?></h1>
        <p><?php _e('Any existing field from <a target="_blank" href="https://codex.wordpress.org/Database_Description#Table:_wp_posts">wp_posts</a> or custom field from chosen page id.') ?></p>
    </header>
    <?php  if($field): ?>
        <h2 class="text-center"><?php _e('The field '. $field .' form page with id '. $page, 'mogul');  ?></h2>


    <?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main text-center">
            <form class="text-center" method="get">
                <div class="container">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><?php _e('Field name:', 'mogul') ?></label>
                            <input class="w-100" type="text" name="field" value="<?php echo $field ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><?php _e('Page id:', 'mogul') ?></label>
                            <input class="w-100 " type="number" name="page" value="<?php echo $page ?>">
                        </div>
                    </div>
                </div>
            </form>
            <?php

            $result = get_post_field( $field , $page , 'db' );
            $custom_fields = get_field($field, $page);

            if($custom_fields) {
                echo '<pre>';
                    var_dump($custom_fields);
                echo '</pre>';
            }
            elseif ($result) {

                echo  '<br />' . $result;

            }else{
                echo '<br /><h3>'. __('Field not found.', 'mogul') . '</h3>';
            }
            ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

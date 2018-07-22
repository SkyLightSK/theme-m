<?php
require_once get_template_directory() . '/inc/class/Enqueue.php';
require_once get_template_directory() . '/inc/class/Setup.php';
require_once get_template_directory() . '/inc/class/Custom_Header.php';
require_once get_template_directory() . '/inc/class/Widget.php';
require_once get_template_directory() . '/inc/class/Mogul.php';
require_once get_template_directory() . '/inc/class/Customizer.php';
require_once get_template_directory() . '/inc/class/Jetpack.php';
require_once get_template_directory() . '/inc/class/Mogul_Walker_Nav_Menu.php';
require_once get_template_directory() . '/inc/class/Mogul_AJAX.php';

/**
 * Class Init
 *
 * Initializing theme properties
 *
 * @since 1.0.0
 */
class Init
{
    /**
     * Running theme properties
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->setup = new Setup();
        $this->enqueue = new Enqueue();
        $this->custom_header = new Custom_Header();
        $this->widget = new Widget();
        $this->mogul = new Mogul();
        $this->customizer = new Customizer();
        $this->jetpack =  defined( 'JETPACK__VERSION' )  ? new Jetpack() : false ;
        $this->mogul_walker_nav_menu = new Mogul_Walker_Nav_Menu();
        $this->mogul_ajax = new Mogul_AJAX();

    }
}
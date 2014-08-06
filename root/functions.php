<?php
/**
 * {%= title %} functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package {%= title %}
 * @since 0.1.0
 */

// Useful global constants
define( '{%= prefix_caps %}_VERSION', '0.1.0' );

/** * Disable automatic general feed link outputting. */
remove_action('wp_head', 'wp_generator');

function {%= prefix %}_scripts_styles() {
    $postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';
    wp_enqueue_style( '{%= prefix %}', get_template_directory_uri() . "/assets/css/all{$postfix}.css", array(), {%= prefix_caps %}_VERSION );
    wp_enqueue_script( '{%= prefix %}', get_template_directory_uri() . "/assets/js/main{$postfix}.js", array('jquery'), {%= prefix_caps %}_VERSION, true );
}
add_action( 'wp_enqueue_scripts', '{%= prefix %}_scripts_styles' );

function setup_init(){
    // menu
	register_nav_menus(array(
		'main-menu'=>'Главное меню'
	));

    // preview
    if(function_exists( 'add_theme_support' )){
        add_theme_support('post-thumbnails');
        add_image_size('preview', 150, 150, true);
    }

    // sidebar
    $before_widget = '<div class="widget %2$s">';
    $after_widget = '</div>';
    $before_title = '<h3>';
    $after_title = '</h3>';
    if ( function_exists('register_sidebar') ) {
        register_sidebar(array(
            'name' => 'Боковая панель',
            'id' => 'sidebar',
            'before_widget' => $before_widget,
            'after_widget' => $after_widget,
            'before_title' => $before_title,
            'after_title' => $after_title
        ));
    }
}
add_action('init','setup_init');

// theme options
define('BASETHEME_THEME_DIR',  get_template_directory());
define('BASETHEME_INCLUDES', BASETHEME_THEME_DIR . '/includes');
function theme_setup(){
    // Initialise the theme options framework
    if ( !function_exists( 'optionsframework_init' ) ) {
        load_theme_textdomain( 'options_framework_theme', BASETHEME_THEME_DIR . '/includes' );
        define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/includes/options/inc/' );
        require_once dirname( __FILE__ ) . '/includes/options/inc/options-framework.php';
    }

    load_theme_textdomain( '{%= prefix %}', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'theme_setup' );

function custom_post_type() {

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Галерея', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Слайд', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Галерея', 'twentythirteen' ),
        'all_items'           => __( 'Все слайды', 'twentythirteen' ),
        'view_item'           => __( 'Посмотреть', 'twentythirteen' ),
        'add_new_item'        => __( 'Добавить новый слайд', 'twentythirteen' ),
        'add_new'             => __( 'Добавить новый', 'twentythirteen' ),
        'edit_item'           => __( 'Редактировать слайд', 'twentythirteen' ),
        'update_item'         => __( 'Обновить', 'twentythirteen' ),
        'search_items'        => __( 'Искать слайд', 'twentythirteen' ),
        'not_found'           => __( 'Не найдено', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Не найдено в корзине', 'twentythirteen' ),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'Галерея', 'twentythirteen' ),
        'description'         => __( 'Галерея', 'twentythirteen' ),
        'labels'              => $labels,
        'menu_icon'           => 'dashicons-format-gallery',
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );

    // Registering your Custom Post Type
    register_post_type( 'promo', $args );
}
add_action( 'init', 'custom_post_type', 0 );

class mainMenuWalker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='drop-list'><ul>\n";
    }

    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}
function custom_excerpt_length( $length ) {
    return 23;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function custom_excerpt_more() {
    return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more', 999 );

// include widgets
require_once(dirname( __FILE__ ) .'/includes/widgets/posts.php');
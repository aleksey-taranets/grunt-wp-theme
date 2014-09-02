<?php
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
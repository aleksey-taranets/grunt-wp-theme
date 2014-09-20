<?php
function portfolio_post_type() {
    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Работы', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'Работа', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'Наши работы', 'twentythirteen' ),
        'all_items'           => __( 'Все работы', 'twentythirteen' ),
        'view_item'           => __( 'Посмотреть', 'twentythirteen' ),
        'add_new_item'        => __( 'Добавить новую работу', 'twentythirteen' ),
        'add_new'             => __( 'Добавить новую', 'twentythirteen' ),
        'edit_item'           => __( 'Редактировать работу', 'twentythirteen' ),
        'update_item'         => __( 'Обновить', 'twentythirteen' ),
        'search_items'        => __( 'Искать работу', 'twentythirteen' ),
        'not_found'           => __( 'Не найдено', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Не найдено в корзине', 'twentythirteen' ),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'Наши работы', 'twentythirteen' ),
        'description'         => __( 'Работы', 'twentythirteen' ),
        'labels'              => $labels,
        'menu_icon'           => 'dashicons-location-alt',
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
    register_post_type( 'portfolio', $args );

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Категории', 'taxonomy general name' ),
        'singular_name'     => _x( 'Категория', 'taxonomy singular name' ),
        'search_items'      => __( 'Поиск категорий' ),
        'all_items'         => __( 'Все категории' ),
        'parent_item'       => __( 'Родительская категория' ),
        'parent_item_colon' => __( 'Родительская категория:' ),
        'edit_item'         => __( 'Редактировать категорию' ),
        'update_item'       => __( 'Обновить категорию' ),
        'add_new_item'      => __( 'Добавить новую' ),
        'new_item_name'     => __( 'Имя категории' ),
        'menu_name'         => __( 'Категории' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'portfolio-category' ),
    );

    register_taxonomy( 'portfolio-category', array( 'portfolio' ), $args );
}
add_action( 'init', 'portfolio_post_type', 0 );
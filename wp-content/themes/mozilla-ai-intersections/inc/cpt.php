<?php

    /**
     * Register AI Intersections custom post type and subsequent taxonomies.
     */
    function register_ai_intersections() {
        /* Register custom post type */
        $labels = array(
            'name' => _x( 'AI Intersections', 'Post Type General Name', 'ai-intersections' ),
            'singular_name' => _x( 'AI Intersection', 'Post Type Singular Name', 'ai-intersections' ),
            'menu_name' => __( 'AI Intersections', 'ai-intersections' ),
            'name_admin_bar' => __( 'AI Intersection', 'ai-intersections' ),
            'archives' => __( 'Intersection Archives', 'ai-intersections' ),
            'attributes' => __( 'Intersection Attributes', 'ai-intersections' ),
            'parent_item_colon' => __( 'Parent Intersection:', 'ai-intersections' ),
            'all_items' => __( 'All Intersections', 'ai-intersections' ),
            'add_new_item' => __( 'Add New Intersection', 'ai-intersections' ),
            'add_new' => __( 'Add New', 'ai-intersections' ),
            'new_item' => __( 'New Intersection', 'ai-intersections' ),
            'edit_item' => __( 'Edit Intersection', 'ai-intersections' ),
            'update_item' => __( 'Update Intersection', 'ai-intersections' ),
            'view_item' => __( 'View Intersection', 'ai-intersections' ),
            'view_items' => __( 'View Intersections', 'ai-intersections' ),
            'search_items' => __( 'Search Intersections', 'ai-intersections' ),
            'not_found' => __(  'Not found', 'ai-intersections' ),
            'not_found_in_trash' => __( 'Not found in Trash', 'ai-intersections' ),
            'items_list' => __( 'Intersections list', 'ai-intersections' ),
            'items_list_navigation' => __( 'Intersections list navigation', 'ai-intersections' )
        );

        $args = array(
            'label' => __( 'AI Intersection', 'ai-intersections' ),
            'description' => __( 'Custom Post Type Description', 'ai-intersections' ),
            'labels' => $labels,
            'supports'  => array( 'title', 'thumbnail', 'excerpt', 'revisions' ),
            'taxonomies' => array( 'post_tag' ),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 3,
            'menu_icon' => 'dashicons-admin-site',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'rewrite' => array( 
                    'slug' => 'ai-intersections-database',
                    'with_front' => false,
                    'feeds'      => false 
                ),
            'exclude_from_search' => false,
            // 'publicly_queryable' => true,
            // 'capability_type' => 'post',
            'with_front' => true
        );

        register_post_type( 'ai_intersections', $args );

        /* Register taxonomies */
        $taxonomies = array(
            'type' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'Types',
                        'singular_name' => 'Type',
                        'add_new_item' => 'Add New Type'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'type' )
                )
            ),
            'actor_type' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'Actor Types',
                        'singular_name' => 'Actor Type',
                        'add_new_item' => 'Add New Actor Type'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'actor-type' )
                )
            ),
            'justice_area' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'Justice Areas',
                        'singular_name' => 'Justice Area',
                        'add_new_item' => 'Add New Justice Area'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'justice-area' )
                )
            ),
            'ai_impact' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'AI Impacts',
                        'singular_name' => 'AI Impact',
                        'add_new_item' => 'Add New AI Impact'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'ai-impact' )
                )
            ),
            'service_area' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'Service Areas',
                        'singular_name' => 'Service Area',
                        'add_new_item' => 'Add New Service Area'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'service-areas' )
                )
            ),
            'region' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'Regions',
                        'singular_name' => 'Region',
                        'add_new_item' => 'Add New Region'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'regions' )
                )
            ),
            'service_year' => array(
                'post_type' => 'ai_intersections',
                'args' => array(
                    'labels' => array(
                        'name' => 'Years',
                        'singular_name' => 'Year',
                        'add_new_item' => 'Add New Year'
                    ),
                    'public' => true,
                    'hierarchical' => true,
                    'rewrite' => array( 'slug' => 'service-year' )
                )
            )
        );

        foreach ( $taxonomies as $taxonomy => $config ):
            register_taxonomy( $taxonomy, $config['post_type'], $config['args'] );
        endforeach;

        /* Unregister default taxonomies */
        unregister_taxonomy_for_object_type( 'category', 'ai_intersections' );
        unregister_post_type( 'post' );
    }
    add_action( 'init', 'register_ai_intersections');

    if ( ! function_exists( 'my_remove_menu_pages' ) ) { 
        function my_remove_menu_pages() {
            remove_menu_page('edit.php');
        }
        add_action( 'admin_menu', 'my_remove_menu_pages' );
    }

    /**
     * Match the published date to the updated date when an AI intersections custom post is updated.
     */
    function match_updated_date( $post_ID, $post_after, $post_before ) {
        if ( 'ai_intersections' === get_post_type( $post_ID ) ):
            remove_action( 'post_updated', 'match_updated_date', 10 );

            wp_update_post(
                array(
                    'ID' => $post_ID,
                    'post_date' => current_time( 'mysql' ),
                    'post_date_gmt' => current_time( 'mysql', 1 )
                )
            );

            add_action( 'post_updated', 'match_updated_date', 10, 3 );
        endif;
    }
    add_action( 'post_updated', 'match_updated_date', 10, 3 );

    /**
     * Change "Published" to "Updated" in Date column of AI Intersections list view.
     */
    function update_date_text( $translated_text, $text, $domain ) {
        if ( is_admin() && 'ai_intersections' === get_post_type() ):
            if ( $text === 'Published' ) $translated_text = 'Updated:';
        endif;

        return $translated_text;
    }
    add_filter( 'gettext', 'update_date_text', 20, 3 );

    /**
     * Add additional CSS to the AI Intersections list view to style the Date column.
     */
    function last_updated_styles() {
        $screen = get_current_screen();
        
        if ( 'edit-ai_intersections' === $screen->id ):
            echo '
                <style>
                    .fixed .column-date {
                        width: 170px;
                    }
                </style>
            ';
        endif;
    }
    add_action( 'admin_head', 'last_updated_styles' );

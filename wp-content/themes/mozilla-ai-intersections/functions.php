<?php

    /**
     * Enqueue admin assets.
     */
    function enqueue_admin_scripts() {
        $theme = wp_get_theme();
        
        /* Enqueue styles */
        wp_enqueue_style( 'google-fonts-preconnect', 'https://fonts.googleapis.com' );
        wp_enqueue_style( 'google-fonts-static', 'https://fonts.gstatic.com' );
        wp_enqueue_style( 'google-fonts-zilla-slab', 'https://fonts.googleapis.com/css2?family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap' );
        wp_enqueue_style( 'google-fonts-nunito-sans', 'https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap' );
        wp_enqueue_style( 'admin-styles', get_stylesheet_directory_uri() . '/dist/css/admin.css', array(), $theme->get( 'Version' ) );
    }
    add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts' );

    /**
     * Enqueue theme assets.
     */
    function enqueue_theme_scripts() {
        $theme = wp_get_theme();

        /* Enqueue styles */
        wp_enqueue_style( 'google-fonts-preconnect', 'https://fonts.googleapis.com' );
        wp_enqueue_style( 'google-fonts-static', 'https://fonts.gstatic.com' );
        wp_enqueue_style( 'google-fonts-zilla-slab', 'https://fonts.googleapis.com/css2?family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap' );
        wp_enqueue_style( 'google-fonts-nunito-sans', 'https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap' );
        wp_enqueue_style( 'ai-intersections', get_stylesheet_directory_uri() . '/dist/css/app.css', array(), $theme->get( 'Version' ) );

        /* Enqueue scripts */
        wp_enqueue_script( 'ai-intersections', get_stylesheet_directory_uri() . '/dist/js/app.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_theme_scripts' );

    /**
     * Add additional attributes to enqueued scripts.
     */
    function add_crossorigin_attribute( $html, $handle ) {
        if ( $handle === 'google-fonts' || $handle === 'google-fonts-static' || $handle === 'google-fonts-preconnect' ):
            $html = str_replace( 'type=\'text/css\' media=\'all\'', '', $html );
        endif;

        if ( $handle === 'google-fonts-static' || $handle === 'google-fonts-preconnect' ):
            $html = str_replace( 'rel=\'stylesheet\'', 'rel=\'preconnect\'', $html );
        endif;

        if ( $handle === 'google-fonts-static' ):
            $html = str_replace( 'rel=', 'crossorigin rel=', $html );
        endif;

        return $html;
    }
    add_filter( 'style_loader_tag', 'add_crossorigin_attribute', 10, 2 );

    /**
     * Theme support.
     */
    function theme_support() {
        add_theme_support( 'html5', 
            array(
                'search-form', 
                'comment-form', 
                'comment-list', 
                'gallery', 
                'caption' 
            )
        );
        add_theme_support(
            'custom-logo', array(
                'height' => 100,
                'width' => 400,
                'flex-height' => true,
                'flex-width' => true,
                'header-text' => array( 'site-title', 'site-description' )
            )
        );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'responsive-embeds' );
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'editor-styles' );
        add_theme_support( 'align-wide' );
    }
    add_action( 'after_setup_theme', 'theme_support' );

    /**
     * Register menus.
     */
    function register_menus() {
        register_nav_menus(
            array(
                'header-menu' => __( 'Header Menu', 'ai-intersections' ),
                'footer-menu' => __( 'Footer Menu', 'ai-intersections' )
            )
        );
    }
    add_action( 'init', 'register_menus' );
    
    /**
     * Register AI Intersections taxonomies as query variables.
     */
    function register_query_vars( $vars ) {
        $vars[] = 'year';

        return $vars;
    }
    add_filter( 'query_vars', 'register_query_vars' );
    
    /**
	 * Simple helper function to get the current URL.
	 */
	function moz_ai_db_get_current_url() {
		global $wp;
		return esc_url_raw(home_url(add_query_arg(null, $wp->request)));
	}

    /**
     * Setup theme customizations in the WordPress editor.
     */
    require get_template_directory() . '/inc/theme.php';

    /**
     * Manage additional Advanced Custom Fields configuration.
     */
    require get_template_directory() . '/inc/acf.php';

    /**
     * Custom post type configuration.
     */
    require get_template_directory() . '/inc/cpt.php';

    /**
     * Handle meta insert into site head.
     */
    require get_template_directory() . '/inc/meta.php';

    /**
    * Use production images when developing locally.
    */
    if ( $_SERVER['HTTP_HOST'] === 'localhost:8080' ):
        function replace_src_paths( $url ) {
            $local_file_path = ABSPATH . ltrim( parse_url( $url, PHP_URL_PATH ), '/' );
            
            if ( !file_exists( $local_file_path ) ):
                return str_replace( WP_HOME, 'https://aiintersectstg.wpengine.com/', $url );
            endif;

            return $url;
        }
        add_filter( 'wp_get_attachment_url', 'replace_src_paths' );

        function replace_srcset_paths( $sources ) {
            foreach ( $sources as &$source ):
                $local_file_path = ABSPATH . ltrim( parse_url( $source['url'], PHP_URL_PATH ), '/' );
                
                if ( !file_exists( $local_file_path ) ):
                    $source['url'] = str_replace( WP_HOME, 'https://aiintersectstg.wpengine.com/', $source['url'] );
                endif;
            endforeach;

            return $sources;
        }
        add_filter( 'wp_calculate_image_srcset', 'replace_srcset_paths' );
    endif;

<?php
    /**
     * Handle meta insert into site head.
     */
    function insert_meta() {
        $post_type =  get_post_type( $post->ID );

        if ( 
            $post_type !== false && 
            is_singular() 
        ):
            if ( $post_type != 'page' ):
                if (
                    function_exists( 'is_plugin_active' ) && 
                    ( is_plugin_active( 'seo-by-rank-math/rank-math.php' ) || is_plugin_active( 'seo-by-rank-math-pro/rank-math-pro.php' ) ) 
                ):
                else:
                    echo '<meta name="type" content="article">';
                endif;

                if ( 
                    function_exists( 'get_field' ) && 
                    get_field( 'authors', $post->ID ) && 
                    get_field( 'authors', $post->ID) != ''
                ):
                    $authors = get_field( 'authors', $post->ID );

                    foreach( $authors as $author ):
                        if ( isset( $author['author']->ID ) ):
                            echo '<meta name="author" content="' . strip_tags( get_the_title( $author['author']->ID ) ) . '">';
                        endif;
                    endforeach;
                elseif ( function_exists( 'coauthors' ) ):
                    $authors = get_coauthors( $post->ID );

                    foreach( $authors as $author ):
                        echo '<meta name="author" content="' . strip_tags( $author->display_name ) . '">';
                    endforeach;
                elseif ( $post_type == 'page' ):
                    if ( 
                        function_exists( 'is_plugin_active' ) && 
                        ( is_plugin_active( 'seo-by-rank-math/rank-math.php' ) || is_plugin_active( 'seo-by-rank-math-pro/rank-math-pro.php' ) ) 
                    ):
                    else:
                        echo '<meta name="type" content="website">';

                    endif;
                endif;
            else:
                if ( 
                    function_exists( 'is_plugin_active' ) && 
                    ( is_plugin_active( 'seo-by-rank-math/rank-math.php' ) || is_plugin_active( 'seo-by-rank-math-pro/rank-math-pro.php' ) )
                ):
                else:
                    echo '<meta name="type" content="website">';
                endif;
            endif;
        
            if ( 
                function_exists( 'is_plugin_active' ) && 
                ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'wordpress-seo-premium/wp-seo-premium.php' ) ) && 
                ( get_post_meta( $post->ID, '_yoast_wpseo_metadesc' ) !== null && 
                isset( get_post_meta( $post->ID, '_yoast_wpseo_metadesc' )[0] ) && 
                !empty( get_post_meta( $post->ID, '_yoast_wpseo_metadesc')[0] ) && 
                esc_attr( strip_tags( stripslashes( get_post_meta( $post->ID, '_yoast_wpseo_metadesc' )[0] ) ) ) != '' ) 
            ): 
            elseif ( 
                function_exists( 'is_plugin_active' ) && 
                ( is_plugin_active( 'seo-by-rank-math/rank-math.php' ) || is_plugin_active( 'seo-by-rank-math-pro/rank-math-pro.php' ) )
            ):
            else:
                $excerpt = get_the_excerpt( 20 );

                echo '<meta name="description" content="' . esc_attr( strip_tags( stripslashes( $excerpt ) ) ) . '">';
            endif;
        
            $tags = get_the_tag_list( '', ',', '', $post->ID );

            if ( $tags != '' ):
                echo '<meta name="keywords" content="' . strip_tags( $tags ) . '">';
            endif;
        endif;
    }
    add_action( 'wp_head', 'insert_meta', 0 );

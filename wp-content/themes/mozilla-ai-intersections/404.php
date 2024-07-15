<?php
    $slug_full = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
    $slug_pieces = explode( '/', $slug_full );
    $slug_last = end( $slug_pieces );

    if ( preg_match( '/^[a-z]{2}-\d{4}$/i', $slug_last ) ):
        $salesforce_id = strtoupper( str_replace( '-', ' - ', $slug_last ) );

        $args = array(
            'post_type' => 'ai_intersections',
            'meta_query' => array(
                array(
                    'key' => 'salesforce_id',
                    'value' => $salesforce_id,
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1
        );

        $records = new WP_Query( $args );

        if ( $records->have_posts() ):
            while ( $records->have_posts() ):
                $records->the_post();
            
                header( 'Location: ' . home_url() . '/ai-intersections-database/' . sanitize_title( get_field( 'actor_issue' ) ) . '/' );
            endwhile;
        else:
            header( 'Location: ' . home_url() );
            exit;
        endif;
    else:
        header( 'Location: ' . home_url() );
        exit;
    endif;

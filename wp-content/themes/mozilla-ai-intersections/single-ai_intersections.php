<?php 
    /**
    * AI Intersections Actor/Issue
    *
    * @package ai-intersections
    */

    get_header();

    $database_url = ( isset( $_SESSION['query_string'] ) && !empty( $_SESSION['query_string'] ) ) ? site_url( '/ai-intersections-database/' ) . '?' . $_SESSION['query_string'] : site_url( '/ai-intersections-database/' );
    $type = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'names' ) )[0];
    $title_class = ( strtolower( $type ) === 'issue' ) ? ' class="h2 mt-2"' : '';
    $title = get_field( 'actor_issue' );
    $permalink = get_the_permalink();
?>
        <main class="actor-issue">
            <div class="actor-issue__hero <?php echo strtolower( $type ); ?>">
                <div class="container grid grid-cols-12 lg:flex lg:flex-col">
                    <div class="col-span-8">
                        <a href="<?php echo $database_url; ?>" class="arrow back mb-2">Back to AI Intersections Database</a>
                        <h1<?php echo $title_class; ?>><?php echo explicit_encoding( $title ); ?></h1>
                    </div>

                    <div class="col-span-1"></div>

                    <div class="relative col-span-3">
                        <div class="actor-issue__hero__meta absolute z-0 top-0 left-0 flex flex-col gap-5 h-auto min-h-[calc(100%+3rem)] w-full p-7 bg-white lg:relative lg:p-6 lg:mt-10 lg:-mb-10 sm:mt-6 sm:-mb-12">
                            <span class="type flex items-center justify-start gap-2 mb-2"><?php echo $type; ?></span>

                            <?php
                                $taxonomies = get_post_taxonomies( get_the_ID() );

                                foreach ( $taxonomies as $taxonomy ):
                                    if ( 
                                        $taxonomy !== 'type' &&
                                        $taxonomy !== 'service_area'
                                    ):
                                        $terms = wp_get_post_terms( get_the_ID(), $taxonomy, array( 'fields' => 'names' ) );
                                        if ( $taxonomy == "region" ) {
                                            if ( is_array($terms) ) {
                                                $terms = array_merge($terms, wp_get_post_terms( get_the_ID(), "service_area", array( 'fields' => 'names' ) ));
                                            } else {
                                                $terms = wp_get_post_terms( get_the_ID(), "service_area", array( 'fields' => 'names' ) );
                                            }
                                            $terms = array_unique($terms);
                                        }
                                        $order;

                                        if ( !empty( $terms ) && !is_wp_error( $terms ) ):
                                            if ( $taxonomy === 'actor_type' ):
                                                $taxonomy = 'Actor Type';
                                                $order = 1;
                                            elseif ( $taxonomy === 'justice_area' ):
                                                $taxonomy = 'Justice Area(s)';
                                                $order = 2;
                                            elseif ( $taxonomy === 'ai_impact' ):
                                                $taxonomy = 'AI Impact(s)';
                                                $order = 3;
                                            elseif ( $taxonomy === 'service_year' ):
                                                $taxonomy = 'Year';
                                                $order = 4;
                                            elseif ( $taxonomy === 'region' ):
                                                $taxonomy = 'Location(s)';
                                                $order = 5;
                                            endif;
                            ?>
                            <div class="flex flex-col gap-1 order-<?php echo $order; ?> text-[16px]">
                                <p><?php echo esc_html( $taxonomy ); ?></p>

                                <?php
                                    foreach ( $terms as $t => $term ):
                                        echo '<p class="font-semibold">' . esc_html( explicit_encoding( $term ) ) . '</p>';

                                        if ( $t > 8 ):
                                            echo '<p class="font-semibold">…</p>';
                                            break;
                                        endif;
                                    endforeach;
                                ?>

                            </div>
                            <?php
                                        endif;
                                    endif;
                                endforeach;
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="container grid grid-cols-12 mt-12 mb-24 lg:mt-16 lg:mb-16 sm:mb-12">
                <div class="col-span-8 lg:col-span-12">
                    <div class="text-[24px] lg:text-[22px] md:text-[20px] sm:text-[18px]"><?php echo preg_replace( '/\s*style=[\'"][^\'"]*[\'"]/', '', explicit_encoding( get_field( 'actor_issue_description' ) ) ); ?></div>

                    <?php
                        if ( 
                            get_field( 'contact_opt_in' ) == 1 &&
                            get_field( 'contact_email_address' )
                        ):
                    ?>
                    <div class="actor-issue__contact relative flex flex-col gap-3 p-8 mt-10 mb-12 bg-white border-2 border-black lg:p-6">
                        <p class="h3 w-full pb-5 mb-4 border-b border-black">Contact <?php the_field( 'actor_issue' ); ?></p>
                        
                        <div class="flex items-center justify-between sm:flex-col sm:items-start sm:gap-3">
                            <p class="font-semibold text-[24px] lg:text-[22px] md:text-[20px] sm:text-[18px]"><?php the_field( 'contact_name' ); ?></p>

                            <a href="mailto:<?php the_field( 'contact_email_address' ); ?>" class="button h-[44.8px] sm:h-auto">Email Contact</a>
                        </div>
                    </div>
                    <?php
                        endif;
                    ?>

                    <div class="flex items-center justify-between mt-8 md:flex-col md:items-start md:gap-8">
                        <div class="flex items-center justify-start gap-4">
                            <p>Share Page</p>

                            <div class="flex items-center justify-start gap-2">
                                <a href="" class="share link relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label='Copy link to "<?php echo $title; ?>" record'></a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $permalink; ?>&title=<?php echo urlencode( $title ); ?>" class="share linkedin relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label='Share "<?php echo $title; ?>" record on LinkedIn' target="_blank"></a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo urlencode( $title ); ?>" class="share twitter relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label='Share <?php echo $title; ?>" record on X (formerly Twitter)' target="_blank"></a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>&quote=<?php echo urlencode( $title ); ?>" class="share facebook relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label='Share "<?php echo $title; ?>" record on Facebook' target="_blank"></a>
                                <a href="mailto:?&body=<?php echo urlencode( $title . ' ' ) . $permalink; ?>" class="share email relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label='Share "<?php echo $title; ?>" record via email' target="_blank"></a>
                            </div>
                        </div>

                        <?php
                            if ( strtolower( $type ) === 'actor' ):
                        ?>
                        <div class="actor-issue__links">
                            <p class="text-[16px]">
                            
                                <?php
                                    echo '<a href="' . get_field( 'form_opt_out' ) . '" target="_blank">Opt Out Link</a>';
                                ?>

                            </p>
                        </div>
                        <?php
                            endif;
                        ?>
                        
                    </div>
                </div>

                <div class="col-span-1"></div>

                <div class="col-span-3">

                </div>
            </div>

            <div class="container mb-20 sm:mb-16">

                <?php
                    $justice_areas = wp_get_post_terms( get_the_ID(), 'justice_area', array( 'fields' => 'ids' ) );

                    $args = array(
                        'post_type' => 'ai_intersections',
                        'posts_per_page' => ( strtolower( $type ) === 'issue' ) ? 4 : 2,
                        'post__not_in' => array( get_the_ID() ),
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'type',
                                'field' => 'slug',
                                'terms' => array( strtolower( $type ) )
                            ),
                            array(
                                'taxonomy' => 'justice_area',
                                'field' => 'term_id',
                                'terms' => $justice_areas
                            ),
                        ),
                    );

                    $justice_area_actors = new WP_Query( $args );

                    if ( $justice_area_actors->have_posts() ):
                ?>
                <h2 class="pt-3 border-t-2 border-black">Related <?php echo $type . 's'; ?> by Justice Area</h2>

                <div class="records grid grid-cols-2 gap-12 mt-10 lg:flex lg:flex-col lg:gap-6">

                    <?php
                        while ( $justice_area_actors->have_posts() ):
                            $justice_area_actors->the_post();

                            $type = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'names' ) )[0];
                            $year = wp_get_post_terms( get_the_ID(), 'service_year', array( 'fields' => 'names' ) )[0];
                            $title = strip_tags( get_field( 'actor_issue' ) );
                            $description = strip_tags( explicit_encoding( get_field( 'actor_issue_description' ) ) );
                            
                            $justice_areas = wp_get_post_terms( get_the_ID(), 'justice_area', array( 'fields' => 'names' ) );

                    ?>
                    <a href="<?php the_permalink(); ?>" class="records__record <?php echo strtolower( $type ); ?> flex flex-col justify-between gap-4 p-8 border-2 transition-colors duration-200 lg:p-6">
                        <span class="flex flex-col gap-2">
                            <span class="flex items-center justify-between gap-2">
                                <span class="type flex items-center justify-center gap-2 mb-1 transition-colors duration-200"><?php echo $type; ?></span>
                                <?php if ( $type == "Issue" ) { ?>
                                    <span class="text-[16px]"><?php echo $year; ?></span>
                                <?php } ?>
                            </span>
                            
                            <h2 class="<?php if ( strtolower( $type ) === 'issue' ) echo 'h3'; ?>"><?php echo explicit_encoding( $title ); ?></h2>
                            <p class="<?php if ( strtolower( $type ) === 'issue' ) echo 'line-clamp-3'; else echo 'line-clamp-5 mt-1'; ?>"><?php echo explicit_encoding( $description ); ?></p>
                        </span>

                        <span class="flex items-end justify-between gap-3">
                            <span class="flex flex-wrap items-center justify-start gap-1">

                                <?php

                                    $tags = array();

                                    if ( is_array($justice_areas) ):
                                        $tags = array_merge(array_map( function( $tag ) {
                                            return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( explicit_encoding( $tag ) ) . '</span>';
                                        }, $justice_areas ), $tags );
                                    endif;

                                    $tags = array_unique( $tags );
                                
                                    echo implode( ' ', $tags );

                                ?>

                            </span>

                            <span class="arrow block min-h-[36px] min-w-[36px] transition-colors duration-200"></span>
                        </span>
                    </a>
                    <?php
                        endwhile;
                    ?>

                </div>
                <?php
                    endif;

                    if ( strtolower( $type ) === 'actor' ):
                        $service_areas = wp_get_post_terms( 
                            get_the_ID(), 'region', array( 
                                'fields' => 'ids' 
                            ) 
                        );

                        foreach ( $service_areas as $service_area ):
                            echo '<script>console.log("' . $service_area . '");</script>';
                        endforeach;

                        $args = array(
                            'post_type' => 'ai_intersections',
                            'posts_per_page' => 2,
                            'post__not_in' => array( get_the_ID() ),
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'type',
                                    'field' => 'slug',
                                    'terms' => array( strtolower( $type ) )
                                ),
                                array(
                                    'taxonomy' => 'region',
                                    'field' => 'term_id',
                                    'terms' => $service_areas
                                ),
                            ),
                        );

                        $service_area_actors = new WP_Query( $args );

                        if ( $service_area_actors->have_posts() ):
                ?>
                <h2 class="pt-3 mt-24 border-t-2 border-black lg:mt-20 sm:mt-16">Related <?php echo $type . 's'; ?> by Service Area</h2>

                <div class="records grid grid-cols-2 gap-12 mt-10 lg:flex lg:flex-col lg:gap-6">

                    <?php
                        while ( $service_area_actors->have_posts() ):
                            $service_area_actors->the_post();

                            $type = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'names' ) )[0];
                            $year = wp_get_post_terms( get_the_ID(), 'service_year', array( 'fields' => 'names' ) )[0];
                            $title = strip_tags( get_field( 'actor_issue' ) );
                            $description = strip_tags( explicit_encoding( get_field( 'actor_issue_description' ) ) );
                            
                            $regions = wp_get_post_terms( 
                                get_the_ID(), 'region', array( 
                                    'fields' => 'names' 
                                ) 
                            );

                    ?>
                    <a href="<?php the_permalink(); ?>" class="records__record <?php echo strtolower( $type ); ?> flex flex-col justify-between gap-4 p-8 border-2 transition-colors duration-200 lg:p-6">
                        <span class="flex flex-col gap-2">
                            <span class="flex items-center justify-between gap-2">
                                <span class="type flex items-center justify-center gap-2 mb-1 transition-colors duration-200"><?php echo $type; ?></span>
                                <?php if ( $type == "Issue" ) { ?>
                                    <span class="text-[16px]"><?php echo $year; ?></span>
                                <?php } ?>
                            </span>
                            
                            <h2 class="<?php if ( strtolower( $type ) === 'issue' ) echo 'h3'; ?>"><?php echo explicit_encoding( $title ); ?></h2>
                            <p class="<?php if ( strtolower( $type ) === 'issue' ) echo 'line-clamp-3'; else echo 'line-clamp-5 mt-1'; ?>"><?php echo explicit_encoding( $description ); ?></p>
                        </span>

                        <span class="flex items-end justify-between gap-3">
                            <span class="flex flex-wrap items-center justify-start gap-1">

                                <?php

                                    $tags = array();

                                    if ( is_array( $regions ) ):
                                        $tags = array_merge(array_map( function( $tag ) {
                                            return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                        }, $regions ), $tags );
                                    endif;

                                    $tags = array_unique( $tags );
                                
                                    echo implode( ' ', $tags );

                                ?>

                            </span>

                            <span class="arrow block min-h-[36px] min-w-[36px] transition-colors duration-200"></span>
                        </span>
                    </a>
                    <?php
                        endwhile;
                    ?>

                </div>
                <?php
                        endif;
                    endif;

                    function explicit_encoding( $string ) {
                        $replacements = array(
                            'Ãƒâ€¦' => 'Å',  // Å (Angstrom)
                            'ÃƒÂ´' => 'ô',   // ô (o circumflex)
                            'ÃƒÂ©' => 'é',   // é (e acute)
                            'â€™' => "'",    // ’ (right single quote)
                            'â€œ' => '"',    // “ (left double quote)
                            'â€“' => '-',    // – (en dash)
                            'â€”' => '—',    // — (em dash)
                            'â€' => '"',     // ” (right double quote)
                            'â€¦' => '...',  // … (ellipsis)
                            'â€¢' => '•',    // • (bullet)
                            'â„¢' => '™',    // ™ (trademark)
                            'â€š' => '‚',    // ‚ (single low-9 quotation mark)
                            'â€ž' => '„',    // „ (double low-9 quotation mark)
                            'â€¹' => '‹',    // ‹ (single left-pointing angle quotation mark)
                            'â€º' => '›',    // › (single right-pointing angle quotation mark)
                            'Â' => '',       // Remove extra "Â" character often seen with misencoding
                            'Ã' => 'Ã',      // Fix for letter "Ã"
                            '�' => ''        // Replacement for unknown character
                        );
                    
                        foreach ( $replacements as $incorrect => $correct ):
                            $string = str_replace( $incorrect, $correct, $string );
                        endforeach;
                    
                        return $string;
                    }
                ?>

            </div>
        </main><!-- #page -->
<?php 
    get_footer();

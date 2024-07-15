<?php 
    /**
    * Front Page
    *
    * @package ai-intersections
    */

    get_header();

    $feature = get_the_post_thumbnail_url( get_the_ID(), 'full' );
?>
        <main class="page">
            <div class="hero relative flex items-center justify-start h-auto pt-44 pb-80 w-full bg-[#BBBEF6] xl:pt-36 lg:pt-28 lg:pb-0 sm:pt-24">
                <div class="container grid grid-cols-2 lg:flex lg:flex-col lg:gap-5 md:gap-3 sm:gap-1">
                    <h1 class="col-span-1 text-[48px]"><?php the_title(); ?></h1>

                    <?php
                        $hero_image = wp_get_attachment_image_src( get_field( 'hero_background' ), 'full' );
                        echo '<img src="' . esc_url( $hero_image[0] ) . '" class="absolute bottom-0 left-1/2 w-screen max-w-[960px] mt-8 -ml-24 2xl:max-w-[920px] xl:max-w-[880px] xl:mt-4 xl:-ml-28 lg:relative lg:w-full lg:max-w-none lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0 md:w-screen md:max-w-[100vw] sm:w-[130vw] sm:max-w-[130vw] sm:ml-5 xs:w-[160vw] xs:max-w-[160vw] xs:ml-10" width="' . $hero_image[1] / 2 . '" alt="' . get_the_title() . '">';
                    ?>

                </div>
            </div>
            
            <div class="container transform -translate-y-2/3 lg:mb-20 lg:translate-y-[-78px] sm:mb-24 sm:translate-y-[-76px]">
                <div class="database-search px-8 py-12 bg-[#151515] xl:py-10 lg:py-6">
                    <form id="database-search" action="/" method="GET" class="flex items-center justify-between gap-4 lg:flex-col lg:items-start">
                        <input id="search-toggle" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                        <label for="search-toggle" class="font-header font-medium text-white text-[22px] leading-[1.3] whitespace-nowrap mr-4 lg:flex lg:items-center lg:justify-between lg:gap-6 lg:w-full lg:mr-0 sm:text-[20px]">Search the database<span class="lg:hidden">:</span></label>

                        <div class="database-search__container flex items-center justify-between gap-4 lg:hidden lg:flex-col lg:gap-0">
                            <input id="search" type="text" name="s" placeholder="Find a social justice issue, AI impact, movement actor, or location"<?php if ( isset( $_GET['search'] ) ) echo ' value="' . $_GET['search'] . '"'; ?>>
                            <input type="hidden" name="post_type" value="ai_intersections">
                            <input id="search-submit" type="submit" value="Search">
                        </div>
                    </form>
                </div><!-- .database-search -->

                <div id="browse-justice-area" class="px-8 py-12 bg-blue-40 border-2 border-black xl:py-10 lg:py-6">
                    <div class="flex items-center justify-between gap-4 lg:flex-col lg:items-start">
                        <input id="justice-area-toggle" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                        <label for="justice-area-toggle" class="font-header font-medium text-white text-[22px] leading-[1.3] w-[200px] pr-2 mr-4 lg:flex lg:items-center lg:justify-between lg:gap-14 lg:w-full lg:pr-0 lg:mr-0 sm:text-[20px]">Browse database by justice areas<span class="lg:hidden">:</span></label>

                        <div class="flex flex-wrap gap-3 w-[calc(100%-200px)] lg:hidden lg:flex-col lg:gap-3 lg:w-full">

                            <?php
                                $slugs = array(
                                    'community-health-and-collective-security',
                                    'disability-justice',
                                    'economic-justice',
                                    'environmental-justice',
                                    'gender-justice',
                                    'human-rights',
                                    'racial-justice'
                                );

                                $args = array(
                                    'taxonomy' => 'justice_area',
                                    'slug' => $slugs,
                                    'hide_empty' => true
                                );

                                $justice_areas = get_terms( $args );

                                foreach ( $justice_areas as $justice_area ):
                            ?>
                            <a href="/ai-intersections-database/?justice_area=<?php echo esc_html( $justice_area->slug ); ?>" class="relative block text-center w-fit lg:mx-auto">
                                <span class="relative z-10 flex items-center justify-center font-medium leading-[1.2] h-[38px] w-fit px-[18px] bg-white border-2 border-black rounded-full transition-colors duration-200 xl:text-[18px] xl:h-[36px] lg:text-[16px] lg:h-auto lg:py-2"><?php echo esc_html( $justice_area->name ); ?></span>
                            </a>
                            <?php
                                endforeach;
                            ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="main-wrapper -mt-56 mb-32 xl:mb-24 lg:-mt-20 lg:mb-16 sm:-mt-24 sm:mb-12">
                    <div class="main-wrapper__content">

                        <?php 
                            the_content();
                        ?>

                    </div>
                    
                    <div class="records grid grid-cols-2 gap-12 mt-20 xl:gap-10 lg:flex lg:flex-col lg:gap-16 lg:mt-10">

                        <?php
                            $args = array(
                                'post_type' => 'ai_intersections',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'type',
                                        'field' => 'slug',
                                        'terms' => 'issue'
                                    ),
                                ),
                                'meta_query' => array(
                                    array(
                                        'key' => 'featured',
                                        'value' => '1',
                                        'compare' => '=',
                                        'type' => 'BOOLEAN'
                                    )
                                )
                            );
                            
                            $featured_issue = new WP_Query( $args );
                            
                            if ( $featured_issue->have_posts() ):
                                while ( $featured_issue->have_posts() ):
                                    $featured_issue->the_post();

                                    $type = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'names' ) )[0];
                                    $year = wp_get_post_terms( get_the_ID(), 'service_year', array( 'fields' => 'names' ) )[0];
                                    $title = strip_tags( get_field( 'actor_issue' ) );
                                    $description = strip_tags( get_field( 'actor_issue_description' ) );
                                    
                                    $justice_areas = wp_get_post_terms( get_the_ID(), 'justice_area', array( 'fields' => 'names' ) );
                                    $ai_impacts = wp_get_post_terms( get_the_ID(), 'ai_impact', array( 'fields' => 'names' ) );
                                    $regions = wp_get_post_terms( get_the_ID(), 'region', array( 'fields' => 'names' ) );
                                    $server_areas = wp_get_post_terms( get_the_ID(), 'service_area', array( 'fields' => 'names' ) );
                                    $actor_type = wp_get_post_terms( get_the_ID(), 'actor_type', array( 'fields' => 'names' ) );

                        ?>
                        <div class="lg:pt-6 lg:border-t lg:border-black">
                            <div class="flex items-center justify-between mb-5 sm:flex-col sm:items-start">
                                <h2>Featured Issue</h2>
                                <a href="/ai-intersections-database/?type=issue" class="arrow forward mb-0">See All Issues</a>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="records__record <?php echo strtolower( $type ); ?> flex flex-col gap-3 h-[calc(100%-20px)] p-8 border-2 transition-colors duration-200 lg:p-6">
                                <span class="flex items-center justify-between gap-2">
                                    <span class="type flex items-center justify-center gap-2 mb-1 transition-colors duration-200"><?php echo $type; ?></span>
                                    <?php if ( $type == "Issue" ) { ?>
                                        <span class="text-[16px]"><?php echo $year; ?></span>
                                    <?php } ?>
                                </span>
                                
                                <h2 class="<?php if ( strtolower( $type ) === 'issue' ) echo 'h3'; ?>"><?php echo $title; ?></h2>
                                <p class="<?php if ( strtolower( $type ) === 'issue' ) echo 'line-clamp-3'; else echo 'line-clamp-5'; ?>"><?php echo $description; ?></p>

                                <span class="absolute bottom-8 flex items-center justify-between gap-3 w-[calc(100%-4rem)] lg:relative lg:bottom-[unset] lg:w-full">
                                    <span class="flex items-center justify-start gap-1">

                                        <?php

                                                $tags = array();

                                                /* if ( is_array($actor_type) && $type == "Actor" ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $actor_type), $tags);
                                                } */

                                                if ( is_array($justice_areas) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $justice_areas), $tags);
                                                }

                                                /*
                                                if ( is_array($ai_impacts) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $ai_impacts), $tags);
                                                }

                                                if ( is_array($regions) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $regions), $tags);
                                                }

                                                if ( is_array($server_areas) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $server_areas), $tags);
                                                } */

                                                $tags = array_unique($tags);
                                            
                                                echo implode( ' ', $tags );

                                        ?>

                                    </span>

                                    <span class="arrow block min-h-[36px] min-w-[36px] transition-colors duration-200"></span>
                                </span>
                            </a>
                        </div>
                        <?php
                                endwhile;
                            endif;
                            
                            $args = array(
                                'post_type' => 'ai_intersections',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'type',
                                        'field' => 'slug',
                                        'terms' => 'actor'
                                    ),
                                ),
                                'meta_query' => array(
                                    array(
                                        'key' => 'featured',
                                        'value' => '1',
                                        'compare' => '=',
                                        'type' => 'BOOLEAN'
                                    )
                                )
                            );
                            
                            $featured_actor = new WP_Query( $args );
                            
                            if ( $featured_actor->have_posts() ):
                                while ( $featured_actor->have_posts() ):
                                    $featured_actor->the_post();

                                    $type = wp_get_post_terms( get_the_ID(), 'type', array( 'fields' => 'names' ) )[0];
                                    $year = wp_get_post_terms( get_the_ID(), 'service_year', array( 'fields' => 'names' ) )[0];
                                    $title = strip_tags( get_field( 'actor_issue' ) );
                                    $description = strip_tags( get_field( 'actor_issue_description' ) );
                                    
                                    $justice_areas = wp_get_post_terms( get_the_ID(), 'justice_area', array( 'fields' => 'names' ) );
                                    $ai_impacts = wp_get_post_terms( get_the_ID(), 'ai_impact', array( 'fields' => 'names' ) );
                                    $regions = wp_get_post_terms( get_the_ID(), 'region', array( 'fields' => 'names' ) );
                                    $server_areas = wp_get_post_terms( get_the_ID(), 'service_area', array( 'fields' => 'names' ) );
                                    $actor_type = wp_get_post_terms( get_the_ID(), 'actor_type', array( 'fields' => 'names' ) );

                        ?>
                        <div class="lg:pt-6 lg:border-t lg:border-black">
                            <div class="flex items-center justify-between mb-5 sm:flex-col sm:items-start">
                                <h2>Featured Actor</h2>
                                <a href="/ai-intersections-database/?type=actor" class="arrow forward mb-0">See All Actors</a>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="records__record <?php echo strtolower( $type ); ?> flex flex-col gap-3 h-[calc(100%-20px)] p-8 border-2 transition-colors duration-200 lg:p-6">
                                <span class="flex items-center justify-between gap-2">
                                    <span class="type flex items-center justify-center gap-2 mb-1 transition-colors duration-200"><?php echo $type; ?></span>
                                    <?php if ( $type == "Issue" ) { ?>
                                        <span class="text-[16px]"><?php echo $year; ?></span>
                                    <?php } ?>
                                </span>
                                
                                <h2 class="<?php if ( strtolower( $type ) === 'issue' ) echo 'h3'; ?>"><?php echo $title; ?></h2>
                                <p class="<?php if ( strtolower( $type ) === 'issue' ) echo 'line-clamp-3'; else echo 'line-clamp-5'; ?>"><?php echo $description; ?></p>

                                <span class="absolute bottom-8 flex items-end justify-between gap-3 w-[calc(100%-4rem)] lg:relative lg:bottom-[unset] lg:w-full">
                                    <span class="flex flex-wrap items-center justify-start gap-1">

                                        <?php

                                                $tags = array();

                                                /* if ( is_array($actor_type) && $type == "Actor" ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $actor_type), $tags);
                                                } */

                                                if ( is_array($justice_areas) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $justice_areas), $tags);
                                                }

                                                /*
                                                if ( is_array($ai_impacts) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $ai_impacts), $tags);
                                                }

                                                if ( is_array($regions) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $regions), $tags);
                                                }

                                                if ( is_array($server_areas) ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $server_areas), $tags);
                                                } */

                                                $tags = array_unique($tags);
                                            
                                                echo implode( ' ', $tags );
                                        ?>

                                    </span>

                                    <span class="arrow block min-h-[36px] min-w-[36px] transition-colors duration-200"></span>
                                </span>
                            </a>
                        </div>
                        <?php
                                endwhile;
                            endif;
                        ?>

                    </div>

                    <a href="/ai-intersections-database/" class="button block mt-28 mx-auto lg:mt-12">Go to database</a>
                </div>
            </div>
        </main><!-- #page -->
<?php 
    get_footer();

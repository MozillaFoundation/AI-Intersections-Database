<?php 
    /**
    * AI Intersections Database
    *
    * @package ai-intersections
    */

    get_header();
?>
        <main class="page">
            <div class="flex items-center justify-start h-auto py-44 w-full bg-[#BBBEF6] lg:py-28">
                <div class="container">
                    <h1>AI Intersections Database</h1>
                </div>
            </div>

            <div class="container transform -translate-y-1/2 lg:translate-y-[-38px]">
                <div class="database-search px-8 py-12 bg-[#151515] xl:py-10 lg:py-6">
                    <form id="database-search" action="/" method="GET" class="flex items-center justify-between gap-4 lg:flex-col lg:items-start">
                        <input id="search-toggle" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                        <label for="search-toggle" class="font-header font-medium text-white text-[22px] leading-[1.3] whitespace-nowrap mr-4 lg:flex lg:items-center lg:justify-between lg:gap-6 lg:w-full lg:mr-0 sm:text-[20px]">Search the database<span class="lg:hidden">:</span></label>

                        <div class="database-search__container flex items-center justify-between gap-4 lg:hidden lg:flex-col lg:gap-0">
                            <input id="search" type="text" name="s" placeholder="Find a social justice issue, AI impact, movement actor, or location"<?php if ( isset( $_GET['search'] ) ) echo ' value="' . sanitize_text_field($_GET['search']) . '"'; ?>>
                            <input type="hidden" name="post_type" value="ai_intersections">
                            <input id="search-submit" type="submit" value="Search">
                        </div>
                    </form>
                </div><!-- .database-search -->
            </div>

            <div id="database-results" class="container grid grid-cols-12 lg:gap-12 md:flex md:flex-col md:gap-0">
                <div class="col-span-3 mb-14 border-t-[3px] border-black lg:col-span-4">
                    <div class="flex items-center justify-between py-8 border-b border-grey-40 lg:py-6 sm:py-4">
                        <p class="h4">Filters</p>
                        <p class="clear-all main">Clear All</p>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            $tags = array();
                            if ( isset( $_GET['type'] ) ) $tags = explode( ',', $_GET['type'] );

                            $args = array(
                                'taxonomy' => 'type',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            );
                            $types = get_terms( $args );
                        ?>
                        <input id="filter-type" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['type'] ) ) echo ' checked'; ?>>
                        <label for="filter-type" class="relative cursor-pointer"><span class="font-semibold">Type</span> (<?php echo count( $types ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input">
                                <input id="main_type-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="main_type-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $types as $type ):
                            ?>
                            <div class="filter-input">
                                <input id="main_type-<?php echo esc_html( $type->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $type->slug ); ?>"<?php if ( in_array( $type->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="main_type-<?php echo esc_html( $type->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( $type->name ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            if ( isset( $_GET['actor_type'] ) ) $tags = explode( ',', $_GET['actor_type'] );

                            $args = array(
                                'taxonomy' => 'actor_type',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            );
                            $actor_types = get_terms( $args );
                        ?>
                        <input id="filter-actor_type" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['actor_type'] ) ) echo ' checked'; ?>>
                        <label for="filter-actor_type" class="relative cursor-pointer"><span class="font-semibold">Actor Type</span> (<?php echo count( $actor_types ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input">
                                <input id="actor_type-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="actor_type-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $actor_types as $actor_type ):
                            ?>
                            <div class="filter-input">
                                <input id="actor_type-<?php echo esc_html( $actor_type->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $actor_type->slug ); ?>"<?php if ( in_array( $actor_type->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="actor_type-<?php echo esc_html( $actor_type->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( $actor_type->name ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            if ( isset( $_GET['justice_area'] ) ) $tags = explode( ',', $_GET['justice_area'] );

                            $args = array(
                                'taxonomy' => 'justice_area',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            );
                            $justice_areas = get_terms( $args );
                        ?>
                        <input id="filter-justice_area" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['justice_area'] ) ) echo ' checked'; ?>>
                        <label for="filter-justice_area" class="relative cursor-pointer"><span class="font-semibold">Justice Area</span> (<?php echo count( $justice_areas ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input">
                                <input id="justice_area-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="justice_area-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $justice_areas as $justice_area ):
                            ?>
                            <div class="filter-input">
                                <input id="justice_area-<?php echo esc_html( $justice_area->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $justice_area->slug ); ?>"<?php if ( in_array( $justice_area->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="justice_area-<?php echo esc_html( $justice_area->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( $justice_area->name ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            if ( isset( $_GET['ai_impact'] ) ) $tags = explode( ',', $_GET['ai_impact'] );

                            $args = array(
                                'taxonomy' => 'ai_impact',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            );
                            $ai_impacts = get_terms( $args );
                        ?>
                        <input id="filter-ai_impact" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['ai_impact'] ) ) echo ' checked'; ?>>
                        <label for="filter-ai_impact" class="relative cursor-pointer"><span class="font-semibold">AI Impact</span> (<?php echo count( $ai_impacts ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input">
                                <input id="ai_impact-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="ai_impact-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $ai_impacts as $ai_impact ):
                            ?>
                            <div class="filter-input">
                                <input id="ai_impact-<?php echo esc_html( $ai_impact->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $ai_impact->slug ); ?>"<?php if ( in_array( $ai_impact->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="ai_impact-<?php echo esc_html( $ai_impact->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( $ai_impact->name ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            if ( isset( $_GET['service_area'] ) ) $tags = explode( ',', $_GET['service_area'] );

                            $all_of_them = get_term_by( 'name', 'All of them', 'service_area');
                            $args = array(
                                'taxonomy' => 'service_area',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'exclude' => array( $all_of_them->term_id )
                            );
                            $service_areas = get_terms( $args );
                        ?>
                        <input id="filter-service_area" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['service_area'] ) ) echo ' checked'; ?>>
                        <label for="filter-service_area" class="relative cursor-pointer"><span class="font-semibold">Country</span> (<?php echo count( $service_areas ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input order-[-4]">
                                <input id="service_area-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="service_area-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $service_areas as $service_area ):
                                    $order = '';

                                    if ( $service_area->name === 'Global' ) $order = ' order-[-3]';
                                    else if ( $service_area->name === 'Global North' ) $order = ' order-[-2]';
                                    else if ( $service_area->name === 'Global South' ) $order = ' order-[-1]';
                            ?>
                            <div class="filter-input<?php echo $order; ?>">
                                <input id="service_area-<?php echo esc_html( $service_area->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $service_area->slug ); ?>"<?php if ( in_array( $service_area->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="service_area-<?php echo esc_html( $service_area->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( explicit_encoding( $service_area->name ) ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            if ( isset( $_GET['region'] ) ) $tags = explode( ',', $_GET['region'] );

                            $args = array(
                                'taxonomy' => 'region',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            );
                            $regions = get_terms( $args );
                        ?>
                        <input id="filter-region" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['region'] ) ) echo ' checked'; ?>>
                        <label for="filter-region" class="relative cursor-pointer"><span class="font-semibold">Region</span> (<?php echo count( $regions ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input order-[-4]">
                                <input id="region-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="region-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $regions as $region ):
                                    $order = '';

                                    if ( $region->name === 'Global' ) $order = ' order-[-3]';
                                    else if ( $region->name === 'Global North' ) $order = ' order-[-2]';
                                    else if ( $region->name === 'Global South' ) $order = ' order-[-1]';
                            ?>
                            <div class="filter-input<?php echo $order; ?>">
                                <input id="region-<?php echo esc_html( $region->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $region->slug ); ?>"<?php if ( in_array( $region->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="region-<?php echo esc_html( $region->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( explicit_encoding( $region->name ) ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col py-4 border-b border-grey-40 md:py-3">

                        <?php
                            if ( isset( $_GET['service_year'] ) ) $tags = explode( ',', $_GET['service_year'] );

                            $args = array(
                                'taxonomy' => 'service_year',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC'
                            );
                            $years = get_terms( $args );
                        ?>
                        <input id="filter-service_year" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none"<?php if ( isset( $_GET['service_year'] ) ) echo ' checked'; ?>>
                        <label for="filter-service_year" class="relative cursor-pointer"><span class="font-semibold">Issue Year</span> (<?php echo count( $years ); ?>)</label>

                        <div class="hidden flex-col gap-3 max-h-[207px] pt-[1px] mt-6 overflow-y-scroll">
                            <div class="filter-input">
                                <input id="service_year-all" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
                                <label for="service_year-all" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]">Select All</label>
                            </div>

                            <?php
                                foreach ( $years as $year ):
                            ?>
                            <div class="filter-input">
                                <input id="service_year-<?php echo esc_html( $year->slug ); ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none" value="<?php echo esc_html( $year->slug ); ?>"<?php if ( in_array( $year->slug, $tags ) ) echo ' checked'; ?>>
                                <label for="service_year-<?php echo esc_html( $year->slug ); ?>" class="flex items-start justify-start gap-2 text-[16px] leading-[1.3]"><?php echo esc_html( $year->name ); ?></label>
                            </div>
                            <?php
                                endforeach;
                            ?>

                            <p class="clear-all mt-1 ml-auto md:mb-1">Clear Selected</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 mt-8">
                        <p>Share Results</p>

                        <div class="flex items-center justify-start gap-2">
                            <a href="" class="share link relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label="Copy the AI Intersections Database link"></a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $permalink; ?>&title=<?php echo urlencode( 'AI Intersections Database' ); ?>" class="share linkedin relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label="Share AI Intersections Database on LinkedIn" target="_blank"></a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo sanitize_text_field( esc_html( home_url( add_query_arg( [] ) ) ) ); ?>&text=<?php echo urlencode( 'AI Intersections Database' ); ?>" class="share twitter relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label="Share AI Intersections Database on X (formerly Twitter)" target="_blank"></a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo sanitize_text_field( esc_html( home_url( add_query_arg( [] ) ) ) ); ?>&quote=<?php echo urlencode( 'AI Intersections Database' ); ?>" class="share facebook relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label="Share AI Intersections Database on Facebook" target="_blank"></a>
                            <a href="mailto:?&body=<?php echo urlencode( 'AI Intersections Database ' ) . $permalink; ?>" class="share email relative min-h-[32px] min-w-[32px] border border-black rounded-full transition-colors duration-200 hover:bg-black" aria-label="Share AI Intersections Database via email" target="_blank"></a>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 xl:col-span-1 lg:hidden"></div>

                <div id="records" class="col-span-7 xl:col-span-8">
                    <div class="async flex items-center justify-between mb-5 xs:flex-col xs:items-start">

                        <?php
                            $tax_query = array( 'relation' => 'AND' );
                            $tax_slugs = array( 'type', 'actor_type', 'justice_area', 'ai_impact', 'service_area', 'region', 'service_year' );
    
                            foreach ( $_GET as $taxonomy => $terms ):
                                if ( in_array( $taxonomy, $tax_slugs ) ):
                                    $terms_array = explode( ',', $terms );
                                    $tax_query[] = array(
                                        'taxonomy' => $taxonomy,
                                        'field' => 'slug',
                                        'terms' => $terms_array
                                    );
                                endif;
                            endforeach;

                            $meta_query = array();

                            if ( isset( $_GET['search'] ) ):
                                $meta_search = sanitize_text_field( $_GET['search'] );
                                $meta_query = array( 'relation' => 'OR' );

                                $meta_query[] = array(
                                    'key' => 'salesforce_id',
                                    'value' => $search,
                                    'compare' => 'LIKE'
                                );

                                $meta_query[] = array(
                                    'key' => 'actor_issue',
                                    'value' => $search,
                                    'compare' => 'LIKE'
                                );

                                $meta_query[] = array(
                                    'key' => 'actor_issue_description',
                                    'value' => $search,
                                    'compare' => 'LIKE'
                                );

                                $meta_query[] = array(
                                    'key' => 'contact_name',
                                    'value' => $search,
                                    'compare' => 'LIKE'
                                );

                                if ( str_contains( $search, '&' ) ):
                                    $alt_search = str_replace( '&', '&amp;', $search );

                                    $meta_query[] = array(
                                        'key' => 'salesforce_id',
                                        'value' => $alt_search,
                                        'compare' => 'LIKE'
                                    );

                                    $meta_query[] = array(
                                        'key' => 'actor_issue',
                                        'value' => $alt_search,
                                        'compare' => 'LIKE'
                                    );
    
                                    $meta_query[] = array(
                                        'key' => 'actor_issue_description',
                                        'value' => $alt_search,
                                        'compare' => 'LIKE'
                                    );

                                    $meta_query[] = array(
                                        'key' => 'contact_name',
                                        'value' => $alt_search,
                                        'compare' => 'LIKE'
                                    );
                                endif;
                            endif;
    
                            $args = array(
                                'post_type' => 'ai_intersections',
                                'posts_per_page' => isset( $_GET['records'] ) ? intval($_GET['records']) : 8,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'tax_query' => $tax_query,
                                'meta_query' => $meta_query
                            );
    
                            if ( isset( $_GET['sort'] ) ):
                                $sort = sanitize_text_field($_GET['sort']);
                                switch ( $sort ):
                                    case 'recent':
                                        $args['orderby'] = 'date';
                                        $args['order'] = 'DESC';
                                        unset( $args['meta_key'] );
    
                                        break;
                                    case 'alphabetical':
                                        $args['orderby'] = 'meta_value';
                                        $args['order'] = 'ASC';
                                        $args['meta_key'] = 'actor_issue';
    
                                        break;
                                endswitch;
                            endif;

                            $sorted;

                            if ( !isset( $_GET['sort'] ) || $_GET['sort'] === 'recent' ) $sorted = 'Recently Added';
                            else $sorted = 'Alphabetical';
    
                            $records = new WP_Query( $args );
                            $records_count;
                            $records_current = ( $_GET['records'] ) ? intval($_GET['records']) : 8;
                            $records_total = $records->found_posts;

                            if ( isset( $_GET['records'] ) ):
                                $records_count = ( intval($_GET['records']) > $records_total ) ? $records_total : intval($_GET['records']);
                            else:
                                $records_count = ( $records_total < 8 ) ? $records_total : 8;
                            endif;

                            if ( isset( $_SERVER['QUERY_STRING'] ) && !empty( $_SERVER['QUERY_STRING'] ) ) $_SESSION['query_string'] = $_SERVER['QUERY_STRING'];
                        ?>

                        <p class="h5">Showing <span id="records-show"><?php echo $records_count; ?></span> out of <span id="records-total"><?php echo $records_total; ?></span> results</p>

                        <div class="flex items-center justify-end gap-2 pt-1">
                            <p class="text-[14px] w-fit">Sort by</p>

                            <div class="flex items-center justify-end gap-2">
                                <div id="sort-records-trigger" class="relative flex items-center justify-end gap-[6px] cursor-pointer font-semibold">
                                    <span><?php echo $sorted; ?></span>

                                    <select id="sort-records" class="absolute top-0 left-0 h-full w-full opacity-0" aria-label="Sort AI Intersections Database records">
                                        <option value="recent"<?php if ( $sorted === 'Recently Added' ) echo ' selected'; ?>>Recently Added</option>
                                        <option value="alphabetical"<?php if ( $sorted === 'Alphabetical' ) echo ' selected'; ?>>Alphabetical</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        if ( $records->have_posts() ):
                    ?>
                    <div class="async records">
                        <div class="mb-20">
                            <div class="async__inner flex flex-col gap-6" data-current="<?php echo $records_current; ?>" data-total="<?php echo $records->found_posts; ?>">

                                <?php
                                    while ( $records->have_posts() ):
                                        $records->the_post();

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
                                <a href="<?php the_permalink(); ?>" class="records__record <?php echo strtolower( $type ); ?> flex flex-col gap-3 p-8 border-2 transition-colors duration-200 lg:p-6">
                                    <span class="flex items-center justify-between gap-2">
                                        <span class="type flex items-center justify-center gap-2 mb-1 transition-colors duration-200"><?php echo $type; ?></span>
                                        <?php if ( $type == "Issue" ) { ?>
                                            <span class="text-[16px]"><?php echo $year; ?></span>
                                        <?php } ?>
                                    </span>
                                    
                                    <h2 class="<?php if ( strtolower( $type ) === 'issue' ) echo 'h3'; ?>"><?php echo explicit_encoding( $title ); ?></h2>
                                    <p class="<?php if ( strtolower( $type ) === 'issue' ) echo 'line-clamp-3'; else echo 'line-clamp-5'; ?>"><?php echo explicit_encoding( $description ); ?></p>

                                    <span class="flex items-end justify-between gap-3 mt-1">
                                        <span class="flex flex-wrap items-center justify-start gap-1">

                                            <?php

                                                $tags = array();

                                                /* if ( is_array($actor_type) && $type == "Actor" ) {
                                                    $tags = array_merge(array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $actor_type), $tags);
                                                } */

                                                if ( is_array( $justice_areas ) ) {
                                                    $tags = array_merge( array_map( function( $tag ) {
                                                        return '<span class="block font-semibold text-[14px] text-center leading-none h-auto px-[10px] py-[5px] border border-black rounded-full xs:max-w-[180px] xs:whitespace-nowrap xs:overflow-hidden xs:text-ellipsis">' . esc_html( $tag ) . '</span>';
                                                    }, $justice_areas), $tags );
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

                                                $tags = array_unique( $tags );
                                            
                                                echo implode( ' ', $tags );

                                            ?>

                                        </span>

                                        <span class="arrow block min-h-[36px] min-w-[36px] transition-colors duration-200"></span>
                                    </span>
                                </a>
                                <?php
                                    endwhile;

                                    if ( $records_count < $records_total ):
                                ?>
                                <a id="load-more-records" href="#" class="flex items-center justify-center font-semibold h-[56px] w-fit pt-[2px] px-4 mt-10 mx-auto border-2 border-black transition-colors duration-200 hover:text-white hover:bg-black">Load More Results</a>
                                <?php
                                    endif;
                                ?>

                            </div>
                        </div>
                    </div>
                    <?php
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
            </div><!-- #database-results -->
        </main><!-- #page -->
<?php 
    get_footer();

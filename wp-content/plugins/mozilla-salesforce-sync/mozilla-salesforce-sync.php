<?php
    /**
     * Plugin Name: Mozilla AI Database | Salesforce Sync
     * Description: Handles sync of issues/actors in Salesforce with their corresponding WordPress posts.
     * Version: 1.0.0
     * Author: Social Driver
     * Author URI: https://www.socialdriver.com/
     */

    require_once( '_config.php' );

    $records_count = 0;
    
    /**
     * Handle Salesforce authentication.
     */
    function get_salesforce_access_token() {
        $url = AUTH_URL;
        $client_id = CLIENT_ID;
        $client_secret = CLIENT_SECRET;
        $username = USERNAME;
        $password = PASSWORD;
        $security_token = SECURITY_TOKEN;
        $params = [
            'grant_type' => 'password',
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'username' => $username,
            'password' => $password . $security_token
        ];

        $curl = curl_init();

        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_HEADER, false );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $params ) );

        $json_response = curl_exec( $curl );
        $http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

        curl_close( $curl );

        $response = json_decode( $json_response, true );

        if ( isset( $response['access_token'] ) ):
            return [
                'success' => true,
                'access_token' => $response['access_token']
            ];
        else:
            $error = isset( $response['error'] ) ? $response['error'] : 'unknown_error';
            $error_description = isset( $response['error_description']) ? $response['error_description'] : 'Unknown error';

            return [
                'success' => false,
                'error' => $error,
                'error_description' => $error_description,
                'http_code' => $http_code
            ];
        endif;
    }

    /**
     * Fetch Salesforce data using SOQL.
     */
    function fetch_soql( $query, $access_token ) {
        global $records_count;
        
        $existing_ids = array();
        $endpoint = SYNC_URL . '?q=' . $query;
        $authorization = "Authorization: Bearer $access_token";

        $curl = curl_init( $endpoint );

        curl_setopt( $curl, CURLOPT_HTTPHEADER, array( $authorization, 'Content-Type: application/json' ) );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

        $json_response = curl_exec( $curl );
        $status = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

        curl_close( $curl );

        if ( $status != 200 ):
            /* Failure */
            $response_body = json_decode( $json_response, true );
            $error_message = json_encode( $response_body, JSON_PRETTY_PRINT );

            echo '<div class="notice notice-error is-dismissible"><p>Failed to fetch data from Salesforce. Response: ' . $error_message . '</p></div>';
        else:
            /* Success */
            $data = json_decode( $json_response, true );
            $success_message = 'Sync complete. ';
            
            foreach ( $data['records'] as $record ):
                /* Grab taxonomy values */
                $name = $record['Name'];
                $type = $record['Actor__c'];
                $actor_issue = $record['Actor__r']['Name'];
                $actor_type = $record['Actor_Type__c'];
                $justice_area = $record['Justice_Area__c'];
                $ai_impacts = $record['AI_Impacts__c'];
                $service_area = $record['Service_Area__c'];
                $regions = $record['Regions__c'];
                $actor_issue_description = $record['Actor_Work_Description__c'];
                $contact_opt_in = $record['Contact_Info_Opt_In__c'];
                $database_opt_in = $record['Database_Opt_In__c'];
                $contact_name = $record['Best_Contact__r']['Name'];
                $contact_email = $record['Best_Contact__r']['Email'];
                $year = $record['Issue_Year__c'];
                $opt_out_form = $record['Unique_Opt_Out_Form_URL__c'];
                $featured = $record['Featured__c'];
                $status = $record['Status__c'];
                $last_modified_date = $record['LastModifiedDate'];

                /* Add Salesforce ID to comparison array */
                $existing_ids[] = $name;

                /* Determine record type */
                if ( $type !== null ):
                    $type = 'Actor';
                else:
                    $type = 'Issue';
                    $actor_issue = $record['How_does_this_manifest_in_society__c'];
                    $actor_issue_description = $record['Issue_Explanation__c'];
                endif;

                generate_record( $name, $type, $actor_issue, $actor_type, $justice_area, $ai_impacts, $service_area, $regions, $actor_issue_description, $contact_opt_in, $database_opt_in, $contact_name, $contact_email, $year, $opt_out_form, $featured, $status, $last_modified_date );
            endforeach;

            $existing_posts = get_posts(
                array(
                    'post_type' => 'ai_intersections',
                    'posts_per_page' => -1,
                    'fields' => 'ids'
                )
            );

            /* Delete posts that no longer exist in Salesforce */
            foreach ( $existing_posts as $post_id ):
                $salesforce_id = get_field( 'salesforce_id', $post_id );

                if ( !in_array( $salesforce_id, $existing_ids ) ):
                    $record_title = get_the_title( $post_id );
                    $records_count++;

                    wp_delete_post( $post_id, true );
                    // echo '<br><strong>Record deleted (removed from Salesforce):</strong> ' . $record_id . ' (' . strip_tags( $record_title ) . ')';
                    echo '<br>Salesforce ID: ' . $salesforce_id;
                endif;
            endforeach;

            if ( $records_count === 1 ) $success_message .= '<strong>1</strong> record created/updated/deleted.';
            else $success_message .= '<strong>' . $records_count . '</strong> records created/updated/deleted.';

            echo '
                <script>
                    (function($) {
                        var notice = $(\'#sync-output\').find(\'.notice\');

                        notice.find(\'p\').html(\'' . $success_message . '\');
                        notice.attr(\'style\', \'\');
                    })(jQuery);
                </script>';
        endif;
    }

    /**
     * Generate AI Intersection record.
     */
    function generate_record( $name, $type, $actor_issue, $actor_type, $justice_area, $ai_impacts, $service_area, $regions, $actor_issue_description, $contact_opt_in, $database_opt_in, $contact_name, $contact_email, $year, $opt_out_form, $featured, $status, $last_modified_date ) {
        global $records_count;

        $record_status = '';

        /* Convert "Contact Opt-In" value */
        if ( $contact_opt_in === true ) $contact_opt_in = 1;
        else $contact_opt_in = 0;

        /* Convert "Database Opt-In" value */
        if ( $database_opt_in === true ) $database_opt_in = 1;
        else $database_opt_in = 0;

        /* Check for existing post by title */
        $existing_post = get_posts(
            array(
                'post_type' => 'ai_intersections',
                'post_status' => 'any',
                'numberposts' => 1,
                'meta_query' => array(
                    array(
                        'key' => 'salesforce_id',
                        'value' => $name,
                        'compare' => '='
                    )
                )
            )
        );

        if ( $existing_post ):
            $post_id = $existing_post[0]->ID;
        else:
            /* Check if record is approved */
            if ( $status === 'Approved' ):
                /* Check if record is an actor and, if so, if the actor has opted in */
                if ( 
                    $type !== 'Actor' ||
                    $type === 'Actor' && $database_opt_in !== 0
                ):
                    $post_atts = [
                        'post_title' => $actor_issue,
                        'post_status' => 'publish',
                        'post_author' => 1,
                        'post_type' => 'ai_intersections'
                    ];
                    
                    $post_id = wp_insert_post( $post_atts );
                    $record_status = 'created';

                    if ( is_wp_error( $post_atts ) ):
                        /* Failure */
                        error_log( 'Failed to create a new custom post: ' . $post_id->get_error_message() );
                    endif;
                endif;
            endif;
        endif;

        $salesforce_date_time = new DateTime( $last_modified_date );
        $wordpress_temp_date_time = get_post_modified_time( 'Y-m-d H:i:s', true, $post_id, true );
        $wordpress_date_time = new DateTime( $wordpress_temp_date_time, new DateTimeZone( 'UTC' ) );

        /* Explode comma-separated strings into multiple values */
        $actor_type = explode( ',', $actor_type );
        $actor_type = array_map( 'trim', $actor_type );

        $justice_area = explode( ',', $justice_area );
        $justice_area = array_map( 'trim', $justice_area );

        $ai_impacts = explode( ',', $ai_impacts );
        $ai_impacts = array_map( 'trim', $ai_impacts );

        $service_area = explode( ',', $service_area );
        $service_area = array_map( 'trim', $service_area );

        $regions = explode( ',', $regions );
        $regions = array_map( 'trim', $regions );

        /* Convert "Featured" value */
        if ( $featured === true ) $featured = 1;
        else $featured = 0;

        /* Check if record has been updated since last sync */
        if ( 
            get_field( 'actor_issue', $post_id ) === null ||
            $salesforce_date_time > $wordpress_date_time
        ):
            /* Check if record is approved */
            if ( $status === 'Approved' ):
                /* Check if record is an actor and, if so, if the actor has opted in */
                if ( 
                    $type !== 'Actor' ||
                    $type === 'Actor' && $database_opt_in !== 0 
                ):
                    /* Set taxonomies */
                    $result_type = wp_set_object_terms( $post_id, $type, 'type', false );
                    $result_actor_type = wp_set_object_terms( $post_id, $actor_type, 'actor_type', false );
                    $result_justice_area = wp_set_object_terms( $post_id, $justice_area, 'justice_area', false );
                    $result_ai_impacts = wp_set_object_terms( $post_id, $ai_impacts, 'ai_impact', false );
                    $result_service_area = wp_set_object_terms( $post_id, $service_area, 'service_area', false );
                    $result_region = wp_set_object_terms( $post_id, $regions, 'region', false );
                    $result_year = wp_set_object_terms( $post_id, $year, 'service_year', false );
                    $records_count++;

                    /* Set Advanced Custom Fields */
                    update_field( 'salesforce_id', $name, $post_id );
                    update_field( 'actor_issue', $actor_issue, $post_id );
                    update_field( 'actor_issue_description', $actor_issue_description, $post_id );
                    update_field( 'contact_opt_in', $contact_opt_in, $post_id );
                    update_field( 'contact_name', $contact_name, $post_id );
                    update_field( 'contact_email_address', $contact_email, $post_id );
                    update_field( 'featured', $featured, $post_id );
                    update_field( 'form_opt_out', $opt_out_form, $post_id );

                    /* Update record status */
                    if ( $record_status !== 'created' ) $record_status = 'updated';

                    /* Update post published date */
                    wp_update_post(
                        array(
                            'ID' => $post_id,
                            'post_date' => get_date_from_gmt( $last_modified_date ),
                            'post_date_gmt' => $salesforce_date_time->format( 'Y-m-d H:i:s' ),
                            'post_status' => 'publish'
                        )
                    );

                    /* Set actor/issue as WordPress title */
                    wp_update_post(
                        array(
                            'ID' => $post_id,
                            'post_title' => $actor_issue,
                            'post_name' => sanitize_title( $actor_issue )
                        )
                    );
                else:
                    /* Check if record was created */
                    if ( $existing_post ):
                        /* Update record status */
                        if ( $status !== 'Approved' ) $record_status = 'deleted (not approved)';
                        elseif ( $database_opt_in === 0 ) $record_status = 'deleted (opt-out)';
                        else $record_status = 'deleted';
                        
                        $records_count++;
    
                        /* Delete record */
                        wp_delete_post( $post_id, true );
                    endif;
                endif;
            else:
                /* Check if record was created */
                if ( $existing_post ):
                    /* Update record status */
                    if ( $status !== 'Approved' ) $record_status = 'deleted (not approved)';
                    elseif ( $database_opt_in === 0 ) $record_status = 'deleted (opt-out)';
                    else $record_status = 'deleted';
                    
                    $records_count++;

                    /* Delete record */
                    wp_delete_post( $post_id, true );
                endif;
            endif;
       endif;

       if ( $record_status !== '' ) echo '<br><strong>Record ' . $record_status . ':</strong> ' . $name . ' (' . strip_tags( $actor_issue ) . ')';
    }

    /**
     * Initialize Salesforce Sync admin view.
     */
    function salesforce_sync_menu() {
        add_menu_page(
            'Salesforce Sync',
            'Salesforce Sync',
            'manage_options',
            'salesforce-sync',
            'salesforce_sync',
            'dashicons-update',
            99
        );
    }
    add_action( 'admin_menu', 'salesforce_sync_menu' );

    /**
     * Generate Salesforce Sync admin view layout.
     */
    function salesforce_sync() {
        echo '
            <div id="sync-output" class="wrap">
                <h1>Salesforce Sync</h1>
                <div class="notice notice-success is-dismissible" style="display: none;"><p></p></div>
                <p style="margin: 0.25rem 0 1rem 0;">Create new records and update/delete existing records that have been modified since the previous sync. <a href="/wp-admin/edit.php?post_type=ai_intersections">View all AI Intersections</a>.</p>
                <input id="sync-start" type="submit" name="sync_salesforce" class="button button-blue-40" value="Sync Now">

                <form action="" method="post" style="display: none;">
                    <input id="sync-submit" type="submit" name="sync_salesforce" class="button button-blue-40" value="Sync Now">
                </form>

                <script>
                    (function($) {
                        $(document).on(\'click\', \'#sync-start\', function() {
                            var syncDummy = $(this),
                                syncSubmit = $(\'#sync-submit\'),
                                suffix = [\'\', \'.\', \'..\', \'...\'],
                                current = 0;
                                
                            syncDummy.val(\'Sync in progress\' + suffix[current]);
                            syncDummy.css(\'width\', \'135px\');
                            syncDummy.css(\'text-align\', \'left\');
                            syncDummy.attr(\'disabled\', true);

                            var interval = setInterval(function() {
                                syncDummy.val(\'Sync in progress\' + suffix[current]);
                                current = (current + 1) % suffix.length;
                            }, 350);

                            syncSubmit.click();
                        });
                    })(jQuery);
                </script>
            </div>';

        if ( isset( $_POST['sync_salesforce'] ) ) start_salesforce_sync();
    }

    /**
     * Activate CRON for Salesforce sync automation.
     */
    function activate_salesforce_cron() {
        $timezone = new DateTimeZone( 'America/New_York' );
        $desired_time = new DateTime( '11:33:00', $timezone );
        
        $utc_time = clone $desired_time;
        $utc_time->setTimeZone( new DateTimeZone( 'UTC' ) );

        $timestamp = $utc_time->getTimestamp();
        $timestamp += ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );

        if ( !wp_next_scheduled( 'salesforce_sync_event' ) ):
            wp_schedule_event( $timestamp, 'daily', 'salesforce_sync_event' );
        endif;
    }
    register_activation_hook( __FILE__, 'activate_salesforce_cron' );

    /**
     * Deactivate CRON for Salesforce sync automation.
     */
    function deactivate_salesforce_cron() {
        $timestamp = wp_next_scheduled( 'salesforce_sync_event' );

        wp_unschedule_event( $timestamp, 'salesforce_sync_event' );
    }
    register_deactivation_hook( __FILE__, 'deactivate_salesforce_cron' );

    /**
     * Start Salesforce sync via activated CRON.AI_Impacts__c

     */
    function salesforce_sync_event() {
        start_salesforce_sync();
    }
    add_action( 'salesforce_sync_event', 'salesforce_sync_event' );

    /**
     * Start Salesforce sync.
     */
    function start_salesforce_sync() {
        /* Authenticate with Salesforce */
        $result = get_salesforce_access_token();
        $soql = "SELECT Name, Actor__c, Actor__r.Name, How_does_this_manifest_in_society__c, Actor_Type__c, Justice_Area__c, AI_Impacts__c, Service_Area__c, Regions__c, Issue_Explanation__c, Actor_Work_Description__c, Actor__r.Website, Contact_Info_Opt_In__c, Database_Opt_In__c, Best_Contact__r.Name, Best_Contact__r.Email, Issue_Year__c, Unique_Opt_Out_Form_URL__c, Featured__c, Status__c, LastModifiedDate FROM AI_Intersection__c";
        $query = urlencode( $soql );

        if ( $result['success'] ) $data = fetch_soql( $query, $result['access_token'] );
        else echo 'Error: ' . $result['error'] . ' - ' . $result['error_description'] . ' (HTTP Code: ' . $result['http_code'] . ')';
    }

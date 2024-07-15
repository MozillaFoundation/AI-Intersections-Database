<?php

    /**
     * Register custom theme blocks.
     */
    function register_theme_blocks() {
        if ( function_exists( 'acf_register_block_type' ) ):
            /* Definition block */
            acf_register_block_type(
                array(
                    'name' => 'definition',
                    'title' => __( 'Definition' ),
                    'description'  => __( 'Add a definition accordion.' ),
                    'render_template' => get_template_directory() . '/blocks/definition.php',
                    'category' => 'common',
                    'icon' => 'edit-page',
                    'keywords' => array( 'definition', 'accordion' )
                )
            );
        endif;
    }
    add_action( 'acf/init', 'register_theme_blocks' );

    /**
     * Add custom styling to Advanced Custom Fields.
     */
    function custom_styles() {
        $styles = '
            <style>
                .post-type-ai_intersections #poststuff #side-sortables {
                    display: flex;
                    flex-direction: column;
                }

                .post-type-ai_intersections #poststuff #side-sortables #submitdiv {
                    order: 1;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox {
                    order: 2;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .postbox-header {
                    border-bottom: 1px solid #C3C4C7;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .postbox-header .ui-sortable-handle {
                    font-size: 14px;
                    padding-left: 12px;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .postbox-header .handlediv {
                    height: 36px;
                    width: 36px;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .postbox-header .handlediv .toggle-indicator::before {
                    content: "\f142";
                    display: inline-block;
                    font: normal 20px / 1 dashicons;
                    height: 20px;
                    width: 20px;
                    background-image: none;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .acf-label {
                    display: none;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .acf-input .acf-true-false label span {
                    order: 1;
                    margin: 0;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .acf-true-false label .acf-switch {
                    order: 2;
                    max-width: 86px;
                }

                .post-type-ai_intersections #poststuff #side-sortables .acf-postbox .acf-true-false label {
                    display: flex;
                    flex-direction: column;
                    gap: 0.5rem;
                }

                .post-type-ai_intersections #poststuff #side-sortables #typediv {
                    order: 3;
                }

                .post-type-ai_intersections #poststuff #side-sortables #actor_typediv {
                    order: 4;
                }

                .post-type-ai_intersections #poststuff #side-sortables #justice_areadiv {
                    order: 5;
                }

                .post-type-ai_intersections #poststuff #side-sortables #ai_impactdiv {
                    order: 6;
                }

                .post-type-ai_intersections #poststuff #side-sortables #service_areadiv {
                    order: 7;
                }

                .post-type-ai_intersections #poststuff #side-sortables #regiondiv {
                    order: 8;
                }

                .post-type-ai_intersections #poststuff #side-sortables #service_yeardiv {
                    order: 9;
                }

                #poststuff .acf-postbox .postbox-header {
                    border: none;
                    transition: background-color 0.1s ease;
                }

                #poststuff .acf-postbox .postbox-header .ui-sortable-handle {
                    cursor: pointer;
                    font-size: 13px;
                    padding-left: 16px;
                }

                #poststuff .acf-postbox .postbox-header .handle-actions .acf-hndle-cog,
                #poststuff .acf-postbox .postbox-header .handle-actions .handle-order-higher,
                #poststuff .acf-postbox .postbox-header .handle-actions .handle-order-lower {
                    display: none;
                }

                #poststuff .acf-postbox .handlediv {
                    cursor: pointer;
                    width: 57px;
                }

                #poststuff .acf-postbox.closed .handlediv {
                    transform: rotate(180deg);
                }

                #poststuff .acf-postbox .handlediv span::before {
                    content: "";
                    height: 24px;
                    width: 24px;
                    background-image: url(/wp-content/themes/mozilla-ai-intersections/assets/img/icons/acf.svg);
                    background-position: center;
                    background-repeat: no-repeat;
                }

                .contribute-content::after {
                    display: none;
                }
            </style>';

        echo $styles;
    }
    add_action( 'admin_head', 'custom_styles' );

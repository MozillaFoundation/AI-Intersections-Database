<?php

    /**
     * Add theme-specific settings to WordPress block editor.
     */
    function theme_color_palette() {
        /* Add theme font size support */
        add_theme_support( 'editor-font-sizes', 
            array(
                array(
                    'name' => 'Small',
                    'size' => 14,
                    'slug' => 'small'
                ),
                array(
                    'name' => 'Medium',
                    'size' => 18,
                    'slug' => 'medium'
                ),
                array(
                    'name' => 'Large',
                    'size' => 20,
                    'slug' => 'large'
                ),
                array(
                    'name' => 'Extra Large',
                    'size' => 24,
                    'slug' => 'extra-large'
                )
            ) 
        );

        /* Add theme color support */
        add_theme_support( 'editor-color-palette', 
            array(
                /* Blue */
                array(
                    'name' => 'Blue 5',
                    'slug' => 'blue-5',
                    'color' => '#E7E7FC'
                ),
                array(
                    'name' => 'Blue 10',
                    'slug' => 'blue-10',
                    'color' => '#D3D5FC'
                ),
                array(
                    'name' => 'Blue 20',
                    'slug' => 'blue-20',
                    'color' => '#B7B9FA'
                ),
                array(
                    'name' => 'Blue 40',
                    'slug' => 'blue-40',
                    'color' => '#595CF3'
                ),
                array(
                    'name' => 'Blue 60',
                    'slug' => 'blue-60',
                    'color' => '#3032D9'
                ),
                array(
                    'name' => 'Blue 80',
                    'slug' => 'blue-80',
                    'color' => '#0D10BF'
                ),
                array(
                    'name' => 'Blue 100',
                    'slug' => 'blue-100',
                    'color' => '#0003A6'
                ),
                
                /* Green */
                array(
                    'name' => 'Green 5',
                    'slug' => 'green-5',
                    'color' => '#D8FFF0'
                ),
                array(
                    'name' => 'Green 10',
                    'slug' => 'green-10',
                    'color' => '#ACFFE0'
                ),
                array(
                    'name' => 'Green 20',
                    'slug' => 'green-20',
                    'color' => '#80FFCE'
                ),
                array(
                    'name' => 'Green 40',
                    'slug' => 'green-40',
                    'color' => '#54FFBD'
                ),
                array(
                    'name' => 'Green 60',
                    'slug' => 'green-60',
                    'color' => '#2CC98E'
                ),
                array(
                    'name' => 'Green 80',
                    'slug' => 'green-80',
                    'color' => '#109462'
                ),
                array(
                    'name' => 'Green 100',
                    'slug' => 'green-100',
                    'color' => '#005E3A'
                ),

                /* Purple */
                array(
                    'name' => 'Purple 5',
                    'slug' => 'purple-5',
                    'color' => '#ECD8FE'
                ),
                array(
                    'name' => 'Purple 10',
                    'slug' => 'purple-10',
                    'color' => '#DEB8FE'
                ),
                array(
                    'name' => 'Purple 20',
                    'slug' => 'purple-20',
                    'color' => '#CD97FD'
                ),
                array(
                    'name' => 'Purple 40',
                    'slug' => 'purple-40',
                    'color' => '#8F14FB'
                ),
                array(
                    'name' => 'Purple 60',
                    'slug' => 'purple-60',
                    'color' => '#760BD4'
                ),
                array(
                    'name' => 'Purple 80',
                    'slug' => 'purple-80',
                    'color' => '#5E05AC'
                ),
                array(
                    'name' => 'Purple 100',
                    'slug' => 'purple-100',
                    'color' => '#470085'
                ),

                /* Cyan */
                array(
                    'name' => 'Cyan 5',
                    'slug' => 'cyan-5',
                    'color' => '#ACFFFF'
                ),
                array(
                    'name' => 'Cyan 10',
                    'slug' => 'cyan-10',
                    'color' => '#ACFFFF'
                ),
                array(
                    'name' => 'Cyan 20',
                    'slug' => 'cyan-20',
                    'color' => '#73FFFF'
                ),
                array(
                    'name' => 'Cyan 40',
                    'slug' => 'cyan-40',
                    'color' => '#00FFFF'
                ),
                array(
                    'name' => 'Cyan 60',
                    'slug' => 'cyan-60',
                    'color' => '#00C9C9'
                ),
                array(
                    'name' => 'Cyan 80',
                    'slug' => 'cyan-80',
                    'color' => '#009494'
                ),
                array(
                    'name' => 'Cyan 100',
                    'slug' => 'cyan-100',
                    'color' => '#005E5E'
                ),
                
                /* Grey */
                array(
                    'name' => 'Grey 5',
                    'slug' => 'grey-5',
                    'color' => '#FFFFFF'
                ),
                array(
                    'name' => 'Grey 10',
                    'slug' => 'grey-10',
                    'color' => '#F2F2F2'
                ),
                array(
                    'name' => 'Grey 20',
                    'slug' => 'grey-20',
                    'color' => '#CCCCCC'
                ),
                array(
                    'name' => 'Grey 40',
                    'slug' => 'grey-40',
                    'color' => '#999999'
                ),
                array(
                    'name' => 'Grey 60',
                    'slug' => 'grey-60',
                    'color' => '#666666'
                ),
                array(
                    'name' => 'Grey 80',
                    'slug' => 'grey-80',
                    'color' => '#333333'
                ),
                array(
                    'name' => 'Grey 100',
                    'slug' => 'grey-100',
                    'color' => '#000000'
                )
            ) 
        );
    }
    add_action( 'after_setup_theme', 'theme_color_palette' );

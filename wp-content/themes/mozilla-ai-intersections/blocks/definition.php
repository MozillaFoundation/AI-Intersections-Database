<?php
    /**
     * Definition
     *
     * @param array $block The block settings and attributes.
     * @param string $content The block inner HTML (empty).
     * @param bool $is_preview True during AJAX preview.
     * @param (int|string) $post_id The post ID this block is saved to.
     */

    /* Create id attribute allowing for custom "anchor" value. */
    $id = 'definition-' . $block['id'];

    if ( !empty( $block['anchor'] ) ):
        $id = $block['anchor'];
    endif;

    /* Create class attribute allowing for custom "class_name" and "align" values. */
    $class_name = 'definition';

    if ( !empty( $block['className'] ) ):
        $class_name .= ' ' . $block['className'];
    endif;

    if ( !empty( $block['align'] ) ):
        $class_name .= ' align' . $block['align'];
    endif;

    $title = get_field( 'title' );
    $selector = str_replace(' ', '-', strtolower( $title ) );
    $definition = get_field( 'definition' );
?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
    <input id="<?php echo $selector; ?>" type="checkbox" class="absolute left-[-9999px] opacity-0 appearance-none invisible pointer-events-none">
    <label for="<?php echo $selector; ?>" class="cursor-pointer flex items-center justify-between font-semibold text-[18px] leading-[1.4]"><?php echo $title; ?></label>
    <p class="hidden text-[18px] leading-[1.55]"><?php echo $definition; ?></p>
</div><!-- .<?php echo esc_attr( $class_name ); ?> -->

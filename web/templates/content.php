<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */

// Block direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( class_exists( 'CSF' ) ) {
    // Fetch the blog settings
    $blogtab = lonyo_opt('lonyo_blog_setting');

    // Ensure $blogtab is an array and check if 'lonyo_blog_style' exists
    if( is_array( $blogtab ) && isset( $blogtab['lonyo_blog_style'] ) ) {
        $lonyo_blog_style = $blogtab['lonyo_blog_style'];

        // Load the appropriate template based on blog style
        if( 'blog_style_one' == $lonyo_blog_style ) {
            get_template_part( 'templates/blog-style-one' );
        } elseif( 'blog_style_two' == $lonyo_blog_style ) {
            get_template_part( 'templates/blog-style-two' );
        } else {
            // Fallback to a default template if the blog style doesn't match
            get_template_part( 'templates/blog-style-one' );
        }
    } else {
        // Fallback in case the blog style is not set
        get_template_part( 'templates/blog-style-one' );
    }
} else {
    // Fallback if CSF is not available
    get_template_part( 'templates/blog-style-one' );
}

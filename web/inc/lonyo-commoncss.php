<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit();
}
/**
 * @Packge     : lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://www.mthemeus.com/
 *
 */

// Enqueue CSS
function lonyo_common_custom_css(){
    wp_enqueue_style( 'lonyo-color-schemes', get_template_directory_uri().'/assets/css/color.schemes.css' );
    
    // Retrieve tabbed options
    $tabbed_options = '';
    if ( class_exists('CSF') ) {
        $tabbed_options  = lonyo_opt('lonyo_custom_code_tab');
    }
    
    // Ensure $tabbed_options is an array and check if 'lonyo_css_editor' exists
    if( is_array( $tabbed_options ) && isset( $tabbed_options['lonyo_css_editor'] ) ){
        $CustomCssOpt = $tabbed_options['lonyo_css_editor'];
    } else {
        $CustomCssOpt = '';
    }

    $customcss = "";
    $js_output = "";

    // Header background image logic
    if( get_header_image() ){
        $lonyo_header_bg =  get_header_image();
    } else {
        $meta = get_post_meta( get_the_ID(), 'lonyo_page_meta_section', true );
        
        // Check if $meta is an array and check for breadcrumb settings
        if( is_array( $meta ) && isset( $meta['page_breadcrumb_settings'] ) ){
            if( $meta['page_breadcrumb_settings'] == 'page' && is_page() ){
                if( !empty( $meta['lonyo_breadcumb_image'] ) ){
                    $lonyo_header_bg = $meta['lonyo_breadcumb_image'];
                }
            } else {
                $lonyo_header_bg = lonyo_opt( 'lonyo_allHeader_bg' );
            }
        } else {
            $lonyo_header_bg = lonyo_opt( 'lonyo_allHeader_bg' );
        }
    }

    if( !empty( $lonyo_header_bg ) ){
        $customcss .= ".breadcumb-wrapper{
            background-image:url('{$lonyo_header_bg}')!important;
        }";
    }
    
    // Theme colors
    $lonyo_primary       = lonyo_opt('lonyo_primary');
    $lonyo_heading_color = lonyo_opt('lonyo_heading_color');
    $lonyo_body_color    = lonyo_opt('lonyo_body_color');

    if( !empty( $lonyo_primary ) ) {
        $customcss .= ":root {
            --accent-color: {$lonyo_primary};
        }";
    }

    if( !empty( $lonyo_heading_color ) ) {
        $customcss .= ":root {
            --heading-color: {$lonyo_heading_color};
        }";
    }

    if( !empty( $lonyo_body_color ) ) {
        $customcss .= ":root {
            --body-color: {$lonyo_body_color};
        }";
    }

    // Add custom CSS from options
    if( !empty( $CustomCssOpt ) ){
        $customcss .= $CustomCssOpt;
    }

    // Add inline CSS
    wp_add_inline_style( 'lonyo-color-schemes', $customcss );

    // Add custom JS from options
    if ( lonyo_opt('opt_code_editor_js') !== null ) {
        $js_output .= lonyo_opt('opt_code_editor_js');
    }

    // Add inline JS
    wp_add_inline_script('lonyo-main-script', $js_output);

}
add_action( 'wp_enqueue_scripts', 'lonyo_common_custom_css', 100 );
?>

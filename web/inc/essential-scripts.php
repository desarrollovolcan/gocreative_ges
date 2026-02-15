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

/**
 * Enqueue scripts and styles.
 */
function lonyo_essential_scripts() {

	wp_enqueue_style( 'lonyo-style', get_stylesheet_uri() ,array(), wp_get_theme()->get( 'Version' ) );

    // google font
    wp_enqueue_style( 'lonyo-fonts', lonyo_google_fonts() ,array(), wp_get_theme()->get( 'Version' ) );

    // Font Awesome Five
    wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/css/fontawesome.min.css' ) ,array(), '5.9.0' );

    // Font Awesome Five
    wp_enqueue_style( 'remixicon', get_theme_file_uri( '/assets/css/remixicon.css' ) ,array(), '2.0' );

    // Slick css
    wp_enqueue_style( 'slick', get_theme_file_uri( '/assets/css/slick.min.css' ) ,array(), '4.0.13' );

    // Bootstrap Min
    wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ) ,array(), '4.3.1' );

    // Magnific Popup
    wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.min.css' ), array(), '1.0' );

    // Core Style
    wp_enqueue_style( 'lonyo-woocommerce-style', get_theme_file_uri( '/assets/css/woocommerce.css' ), array(), '1.0' );
    wp_enqueue_style( 'lonyo-core-style', get_theme_file_uri( '/assets/css/core.css' ), array(), '1.0' );
    wp_enqueue_style( 'lonyo-menu-style', get_theme_file_uri( '/assets/css/menu.css' ), array(), '1.0' );

    // lonyo app style
    wp_enqueue_style( 'lonyo-main-style', get_theme_file_uri('/assets/css/style.css') ,array(), time() );
    wp_enqueue_style( 'lonyo-blog-style', get_theme_file_uri('/assets/css/blog-default.css') ,array(), time() );

    // Load Js

    // Bootstrap
    wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), '4.3.1', true );

    // Slick
    wp_enqueue_script( 'slick', get_theme_file_uri( '/assets/js/slick.min.js' ), array('jquery'), '1.0.0', true );

    // magnific popup
    wp_enqueue_script( 'magnific-popup', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array('jquery'), '1.0.0', true );

    // Isotope
    wp_enqueue_script( 'isototpe-pkgd', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array( 'jquery' ), '1.0.0', true );

    // Isotope Imagesloaded
    wp_enqueue_script( 'imagesloaded' );

    // main script
    wp_enqueue_script( 'lonyo-main-script', get_theme_file_uri( '/assets/js/main.js' ), array('jquery'), time(), true );
    
    // comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'lonyo_essential_scripts',99 );


function lonyo_block_editor_assets( ) {
    // Add custom fonts.
	wp_enqueue_style( 'lonyo-editor-fonts', lonyo_google_fonts(), array(), null );
}

add_action( 'enqueue_block_editor_assets', 'lonyo_block_editor_assets' );
 
function lonyo_google_fonts() {
    $font_families = array(
        'DM Sans:400,500,600,700',
    );

    $familyArgs = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,latin-ext' ),
    );

    $fontUrl = add_query_arg( $familyArgs, '//fonts.googleapis.com/css' );

    return esc_url_raw( $fontUrl );
}
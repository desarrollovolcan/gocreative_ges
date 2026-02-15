<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */


// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit;
}

function lonyo_widgets_init() {


    // Sidebar widgets register
    register_sidebar( array(
        'name'          => esc_html__( 'Blog Sidebar', 'lonyo' ),
        'id'            => 'lonyo-blog-sidebar',
        'description'   => esc_html__( 'Add Blog Sidebar Widgets Here.', 'lonyo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget_title">',
        'after_title'   => '</h3>',
    ) );

    // Page sidebar widgets register
    register_sidebar( array(
        'name'          => esc_html__( 'Page Sidebar', 'lonyo' ),
        'id'            => 'lonyo-page-sidebar',
        'description'   => esc_html__( 'Add Page Sidebar Widgets Here.', 'lonyo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget_title">',
        'after_title'   => '</h3>',
    ) );

    // WooCommerce sidebar widgets register
    if( class_exists('woocommerce') ) {
        register_sidebar(
            array(
                'name'          => esc_html__( 'WooCommerce Sidebar', 'lonyo' ),
                'id'            => 'lonyo-woo-sidebar',
                'description'   => esc_html__( 'Add widgets here to appear in your WooCommerce page sidebar.', 'lonyo' ),
                'before_widget' => '<div class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="widget-title"><h4>',
                'after_title'   => '</h4></div>',
            )
        );
    }

}
add_action( 'widgets_init', 'lonyo_widgets_init' );

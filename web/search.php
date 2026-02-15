<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */

// Block direct access
if ( ! defined('ABSPATH') ) {
    exit;
}
    // Header
    get_header();

    /**
    *
    * Hook for Blog Start Wrapper
    *
    * Hook lonyo_blog_start_wrap
    *
    * @Hooked lonyo_blog_start_wrap_cb 10
    *
    */
    do_action( 'lonyo_blog_start_wrap' );

    /**
    *
    * Hook for Blog Column Start Wrapper
    *
    * Hook lonyo_blog_col_start_wrap
    *
    * @Hooked lonyo_blog_col_start_wrap_cb 10
    *
    */
    do_action( 'lonyo_blog_col_start_wrap' );

    /**
    * 
    * Hook for Blog Content
    *
    * Hook lonyo_blog_content
    *
    * @Hooked lonyo_blog_content_cb 10
    *  
    */
    do_action( 'lonyo_blog_content' );

    /**
    *
    * Hook for Blog Pagination
    *
    * Hook lonyo_blog_pagination
    *
    * @Hooked lonyo_blog_pagination_cb 10
    *
    */
    do_action( 'lonyo_blog_pagination' );

    /**
    *
    * Hook for Blog Column End Wrapper
    *
    * Hook lonyo_blog_col_end_wrap
    *
    * @Hooked lonyo_blog_col_end_wrap_cb 10
    *
    */
    do_action( 'lonyo_blog_col_end_wrap' );

    /**
    *
    * Hook for Blog Sidebar
    *
    * Hook lonyo_blog_sidebar
    *
    * @Hooked lonyo_blog_sidebar_cb 10
    *
    */
    do_action( 'lonyo_blog_sidebar' );

    /**
    *
    * Hook for Blog End Wrapper
    *
    * Hook lonyo_blog_end_wrap
    *
    * @Hooked lonyo_blog_end_wrap_cb 10
    *
    */
    do_action( 'lonyo_blog_end_wrap' );

    //footer
    get_footer();
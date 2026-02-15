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
		exit();
	}

	/**
	* Hook for preloader
	*/
	add_action( 'wp_body_open', 'lonyo_preloader_wrap' );

	/**
	 * Hook for Breadcrumb
	 */
	add_action( 'mas_header_builder_content', 'lonyo_breadcrumb_wrap' );

	/**
	* Hook for offcanvas cart
	*/
	add_action( 'lonyo_main_wrapper_start', 'lonyo_main_wrapper_start_cb', 10 );

	/**
	* Hook for Header
	*/
	add_action( 'lonyo_header', 'lonyo_header_cb', 10 );

	/**
	* Hook for Blog Start Wrapper
	*/
	add_action( 'lonyo_blog_start_wrap', 'lonyo_blog_start_wrap_cb', 10 );

	/**
	* Hook for Blog Column Start Wrapper
	*/
    add_action( 'lonyo_blog_col_start_wrap', 'lonyo_blog_col_start_wrap_cb', 10 );

	/**
	* Hook for Service Column Start Wrapper
	*/
    add_action( 'lonyo_service_col_start_wrap', 'lonyo_service_col_start_wrap_cb', 10 );

	/**
	* Hook for Blog Column End Wrapper
	*/
    add_action( 'lonyo_blog_col_end_wrap', 'lonyo_blog_col_end_wrap_cb', 10 );

	/**
	* Hook for Blog Column End Wrapper
	*/
    add_action( 'lonyo_blog_end_wrap', 'lonyo_blog_end_wrap_cb', 10 );

	/**
	* Hook for Blog Pagination
	*/
    add_action( 'lonyo_blog_pagination', 'lonyo_blog_pagination_cb', 10 );

    /**
	* Hook for Blog Content
	*/
	add_action( 'lonyo_blog_content', 'lonyo_blog_content_cb', 10 );

    /**
	* Hook for Blog Sidebar
	*/
	add_action( 'lonyo_blog_sidebar', 'lonyo_blog_sidebar_cb', 10 );


    /**
	* Hook for Service Sidebar
	*/
	add_action( 'lonyo_service_sidebar', 'lonyo_service_sidebar_cb', 10 );

    /**
	* Hook for Blog Details Sidebar
	*/
	add_action( 'lonyo_blog_details_sidebar', 'lonyo_blog_details_sidebar_cb', 10 );

	/**
	* Hook for Blog Details Wrapper Start
	*/
	add_action( 'lonyo_blog_details_wrapper_start', 'lonyo_blog_details_wrapper_start_cb', 10 );

	/**
	* Hook for Blog Post Meta
	*/
	add_action( 'lonyo_blog_post_meta', 'lonyo_blog_post_meta_cb', 10 );


	/**
	* Hook for Blog Details Post Meta
	*/
	add_action( 'lonyo_blog_details_post_meta', 'lonyo_blog_details_post_meta_cb', 10 );

	/**
	* Hook for Blog Details Post Share Options
	*/
	add_action( 'lonyo_blog_details_share_options', 'lonyo_blog_details_share_options_cb', 10 );

	/**
	* Hook for Blog Details post navigation
	*/
	add_action( 'lonyo_blog_details_post_navigation', 'lonyo_blog_details_post_navigation_cb', 10 );



	/**
	* Hook for Blog Details Post Author Bio
	*/
	add_action( 'lonyo_blog_details_author_bio', 'lonyo_blog_details_author_bio_cb', 10 );

	/**
	* Hook for Blog Details Tags and Categories
	*/
	add_action( 'lonyo_blog_details_tags_and_categories', 'lonyo_blog_details_tags_and_categories_cb', 10 );

	/**
	* Hook for Blog Deatils Related Post
	*/
	add_action( 'lonyo_blog_details_related_post', 'lonyo_blog_details_related_post_cb', 10 );

	/**
	* Hook for Blog Deatils Comments
	*/
	add_action( 'lonyo_blog_details_comments', 'lonyo_blog_details_comments_cb', 10 );

	/**
	* Hook for Blog Deatils Column Start
	*/
	add_action('lonyo_blog_details_col_start','lonyo_blog_details_col_start_cb');

	/**
	* Hook for Blog Deatils Column End
	*/
	add_action('lonyo_blog_details_col_end','lonyo_blog_details_col_end_cb');

	/**
	* Hook for Blog Deatils Wrapper End
	*/
	add_action('lonyo_blog_details_wrapper_end','lonyo_blog_details_wrapper_end_cb');

	/**
	* Hook for Blog Post Thumbnail
	*/
	add_action('lonyo_blog_post_thumb','lonyo_blog_post_thumb_cb');

	/**
	* Hook for Blog Post Content
	*/
	add_action('lonyo_blog_post_content','lonyo_blog_post_content_cb');


	/**
	* Hook for Blog Post Excerpt And Read More Button
	*/
	add_action('lonyo_blog_postexcerpt_read_content','lonyo_blog_postexcerpt_read_content_cb');

	/**
	* Hook for footer content
	*/
	add_action( 'lonyo_footer_content', 'lonyo_footer_content_cb', 10 );

	/**
	* Hook for main wrapper end
	*/
	add_action( 'lonyo_main_wrapper_end', 'lonyo_main_wrapper_end_cb', 10 );

	/**
	* Hook for Back to Top Button
	*/
	add_action( 'lonyo_back_to_top', 'lonyo_back_to_top_cb', 10 );

	/**
	* Hook for Page Start Wrapper
	*/
	add_action( 'lonyo_page_start_wrap', 'lonyo_page_start_wrap_cb', 10 );

	/**
	* Hook for Page End Wrapper
	*/
	add_action( 'lonyo_page_end_wrap', 'lonyo_page_end_wrap_cb', 10 );

	/**
	* Hook for Page Column Start Wrapper
	*/
	add_action( 'lonyo_page_col_start_wrap', 'lonyo_page_col_start_wrap_cb', 10 );

	/**
	* Hook for Page Column End Wrapper
	*/
	add_action( 'lonyo_page_col_end_wrap', 'lonyo_page_col_end_wrap_cb', 10 );

	/**
	* Hook for Page Column End Wrapper
	*/
	add_action( 'lonyo_page_sidebar', 'lonyo_page_sidebar_cb', 10 );

	/**
	* Hook for Page Content
	*/
	add_action( 'lonyo_page_content', 'lonyo_page_content_cb', 10 );
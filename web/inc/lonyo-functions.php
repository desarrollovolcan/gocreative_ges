<?php

/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */


// Block direct access
if( ! defined( 'ABSPATH' ) ){
    exit;
}


    if ( ! function_exists( 'lonyo_opt' ) ) {
        function lonyo_opt( $option = '', $default = null ) {
            $options = get_option( 'lonyo_settings' ); 
            return ( isset( $options[$option] ) ) ? $options[$option] : $default;
        }
    }


// theme logo
function lonyo_theme_logo() {
    // escaping allow html
    $allowhtml = array(
        'a'    => array(
            'href' => array()
        ),
        'span' => array(),
        'i'    => array(
            'class' => array()
        )
    );
    $siteUrl = home_url('/');
    if( has_custom_logo() ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $siteLogo = '';
        $siteLogo .= '<a class="logo" href="'.esc_url( $siteUrl ).'">';
        $siteLogo .= lonyo_img_tag( array(
            "class" => "img-fluid logo-img",
            "url"   => esc_url( wp_get_attachment_image_url( $custom_logo_id, 'full') )
        ) );
        $siteLogo .= '</a>';

        return $siteLogo;
    } elseif( class_exists( 'CSF' ) ){

        $logourl = lonyo_opt('dark_logo' );
        $testtitle = lonyo_opt('lonyo_header_settings');
        
        
        if ( !empty( $logourl['url'] ) ) {
            $siteLogo = '<img class="" src="'. esc_url( $logourl['url'] ) .'" alt="'.esc_attr__( 'logo', 'lonyo' ).'" />';
            return '<a class="logo" href="'.esc_url( $siteUrl ).'">'.$siteLogo.'</a>';
        } else {
            if ( ! empty ( $testtitle['lonyo_text_title'] ) ) {
                return '<h3><a class="logo" href="'.esc_url( $siteUrl ).'">'.wp_kses( $testtitle['lonyo_text_title'], $allowhtml ).'</a></h3>';
            } else {
                return '<h3><a class="logo" href="'.esc_url( $siteUrl ).'">'.esc_html( get_bloginfo('name') ).'</a></h3>';
            }
        }
    } else{
        return '<h3><a class="logo" href="'.esc_url( $siteUrl ).'">'.esc_html( get_bloginfo('name') ).'</a></h3>';
    }
}

// Lonyo Coming Soon Logo
function lonyo_coming_soon_logo() {
    // escaping allow html
    $allowhtml = array(
        'a'    => array(
            'href' => array()
        ),
        'span' => array(),
        'i'    => array(
            'class' => array()
        )
    );
    $siteUrl = home_url('/');
    // site logo
    if( lonyo_opt( 'lonyo_coming_logo', 'url' )  ){

        $siteLogo = '<img src="'.esc_url( lonyo_opt('lonyo_coming_logo', 'url' ) ).'" alt="'.esc_attr__( 'logo', 'lonyo' ).'" />';

        return '<a class="logo" href="'.esc_url( $siteUrl ).'">'.$siteLogo.'</a>';

    }elseif( lonyo_opt('lonyo_coming_site_title') ){
        return '<h2 class="mb-0"><a class="text-logo" href="'.esc_url( $siteUrl ).'">'.wp_kses( lonyo_opt('lonyo_coming_site_title'), $allowhtml ).'</a></h2>';
    }else{
        return '<h2 class="mb-0"><a class="text-logo" href="'.esc_url( $siteUrl ).'">'.esc_html( get_bloginfo('name') ).'</a></h2>';
    }
}


// Blog Date Permalink
function lonyo_blog_date_permalink() {
    $year  = get_the_time('Y');
    $month_link = get_the_time('m');
    $day   = get_the_time('d');
    $link = get_day_link( $year, $month_link, $day);
    return $link;
}

//audio format iframe match
function lonyo_iframe_match() {
    $audio_content = lonyo_embedded_media( array('audio', 'iframe') );
    $iframe_match = preg_match("/\iframe\b/i",$audio_content, $match);
    return $iframe_match;
}


//Post embedded media
function lonyo_embedded_media( $type = array() ){
    $content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
    $embed   = get_media_embedded_in_content( $content, $type );


    if( in_array( 'audio' , $type) ){
        if( count( $embed ) > 0 ){
            $output = str_replace( '?visual=true', '?visual=false', $embed[0] );
        }else{
           $output = '';
        }

    }else{
        if( count( $embed ) > 0 ){
            $output = $embed[0];
        }else{
           $output = '';
        }
    }
    return $output;
}


// WP post link pages
function lonyo_link_pages(){
    wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'lonyo' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'lonyo' ) . ' </span>%',
        'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
}


// Data Background image attr
function lonyo_data_bg_attr( $imgUrl = '' ){
    return 'data-bg-img="'.esc_url( $imgUrl ).'"';
}

// image alt tag
function lonyo_image_alt( $url = '' ){
    if( $url != '' ){
        // attachment id by url
        $attachmentid = attachment_url_to_postid( esc_url( $url ) );
       // attachment alt tag
        $image_alt = get_post_meta( esc_html( $attachmentid ) , '_wp_attachment_image_alt', true );
        if( $image_alt ){
            return $image_alt ;
        }else{
            $filename = pathinfo( esc_url( $url ) );
            $alt = str_replace( '-', ' ', $filename['filename'] );
            return $alt;
        }
    }else{
       return;
    }
}


// Flat Content wysiwyg output with meta key and post id

function lonyo_get_textareahtml_output( $content ) {
    global $wp_embed;

    $content = $wp_embed->autoembed( $content );
    $content = $wp_embed->run_shortcode( $content );
    $content = wpautop( $content );
    $content = do_shortcode( $content );

    return $content;
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */

function lonyo_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'lonyo_pingback_header' );





// Excerpt More
function lonyo_excerpt_more( $more ) {
    return '...';
}

add_filter( 'excerpt_more', 'lonyo_excerpt_more' );


// lonyo comment template callback
function lonyo_comment_callback( $comment, $args, $depth ) {
        $add_below = 'comment';
    ?>
    <li <?php comment_class( array('comment-item') ); ?>>
        <div id="comment-<?php comment_ID() ?>" class="post-comment">
            <?php
                if( get_avatar( $comment, 110 )  ) :
            ?>
            <!-- Author Image -->
            <div class="comment-avater">
                <?php
                    if ( $args['avatar_size'] != 0 ) {
                        echo get_avatar( $comment, 110 );
                    }
                ?>
            </div>
            <!-- Author Image -->
            <?php
                endif;
            ?>
            <!-- Comment Content -->
            <div class="comment-content">
                <h4 class="name h4"><?php echo esc_html( ucwords( get_comment_author() ) ); ?></h4>
                <span class="commented-on"> 
                    <?php printf( esc_html__('%1$s', 'lonyo'), get_comment_date() ); ?> 
                </span>
                <?php comment_text(); ?>
                
                <div class="reply_and_edit">
                    <?php
                        comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => 1, 'max_depth' => 5, 'reply_text' => '<i class="ri-reply-fill"></i>Reply' ) ) );
                    ?>
                    <span class="comment-edit-link pl-10"><?php edit_comment_link( '<i class="fas fa-pencil"></i>'.esc_html__( 'Edit', 'lonyo' ), '  ', '' ); ?></span>
                </div>

                <?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'lonyo' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Comment Content -->
<?php
}

//body class
add_filter( 'body_class', 'lonyo_body_class' );
function lonyo_body_class( $classes ) {
    if( class_exists('CSF') ) {
        $blogtab = lonyo_opt('lonyo_blog_setting');

        // Ensure $blogtab is an array and check if 'lonyo_blog_single_sidebar' exists
        if( is_array( $blogtab ) && isset( $blogtab['lonyo_blog_single_sidebar'] ) ) {
            $lonyo_blog_single_sidebar = $blogtab['lonyo_blog_single_sidebar'];

            // Check if the sidebar value is not '2' or '3' and sidebar is not active
            if( ( $lonyo_blog_single_sidebar != '2' && $lonyo_blog_single_sidebar != '3' ) || !is_active_sidebar('lonyo-blog-sidebar') ) {
                $classes[] = 'no-sidebar';
            }
        }
    } else {
        // If CSF is not available, fall back to checking the active sidebar
        if( !is_active_sidebar('lonyo-blog-sidebar') ) {
            $classes[] = 'no-sidebar';
        }
    }
    return $classes;
}


function lonyo_footer_global_option(){

    // Lonyo Footer Bottom Enable Disable
    if( class_exists( 'CSF' ) ){
        $lonyo_footer_bottom_active = lonyo_opt( 'lonyo_disable_footer_bottom' );
    }else{
        $lonyo_footer_bottom_active = false;
    }
   
    $allowhtml = array(
        'p'         => array(
            'class'     => array()
        ),
        'span'      => array(
            'class'     => array(),
        ),
        'a'         => array(
            'href'      => array(),
            'title'     => array()
        ),
        'br'        => array(),
        'em'        => array(),
        'strong'    => array(),
        'b'         => array(),
    );

    if( $lonyo_footer_bottom_active == true ){
        echo '<!-- Footer -->';
        echo '<footer class="footer-wrapper">';

            $allowhtml = array(
                'p'         => array(
                    'class'     => array()
                ),
                'span'      => array(),
                'a'         => array(
                    'href'      => array(),
                    'title'     => array(),
                    'class'     => array(),
                ),
                'br'        => array(),
                'em'        => array(),
                'strong'    => array(),
                'b'         => array(),
            );
            echo '<div class="copyright-wrap">';
                echo '<div class="container">';
                    echo '<div class="row align-items-center">';
                        if( ! empty( lonyo_opt( 'lonyo_copyright_text' ) ) ){
                            echo '<p class="copyright-text">'.wp_kses( lonyo_opt( 'lonyo_copyright_text' ), $allowhtml ).'</p>';
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            
        echo '</footer>';
        echo '<!-- End Footer -->';
    }
}

function lonyo_social_icon(){
    $lonyo_social_icon = lonyo_opt( 'lonyo_social_links' );
    if( ! empty( $lonyo_social_icon ) && isset( $lonyo_social_icon ) ){
        echo '<div class="author-links">';
        foreach( $lonyo_social_icon as $social_icon ){
            if( ! empty( $social_icon['title'] ) ){
                echo '<a href="'.esc_url( $social_icon['url'] ).'"><i class="'.esc_attr( $social_icon['title'] ).'"></i>'.esc_html( $social_icon['description'] ).'</a>';
            }
        }
        echo '</div>';
    }
}


// global header
function lonyo_global_header_option() {
    lonyo_global_header();
    echo '<header class="site-header lonyo-header-section prebuilt-header">';
        echo '<div class="lonyo-header-bottom">';
            echo '<div class="container">';
                echo '<div class=" d-flex align-items-center justify-content-between">';
                        echo '<div class="header-logo">';
                            echo lonyo_theme_logo();
                        echo '</div>';
                        if( has_nav_menu( 'primary-menu' ) ){
                            echo '<nav class="main-menu menu-style1">';
                                wp_nav_menu( array(
                                    "theme_location"    => 'primary-menu',
                                    "container"         => '',
                                    "menu_class"        => ''
                                ) );
                            echo '</nav>';
                        }
                        
                    
                    echo '<div class="col-auto">';
                        echo '<!-- Mobile Menu Toggler -->';
                        echo '<button class="lonyo-menu-toggle"><span></span></button>';
                    echo '</div>';

                echo '</div>';
            echo '</div>';
        echo '</div>';
        if( ! empty( lonyo_opt( 'lonyo_notice_text' ) ) ){
            echo '<div class="header-notice d-none d-md-block">';
                echo '<div class="container">';
                    echo '<p class="mb-0 fs-xs text-title">'.esc_html( lonyo_opt( 'lonyo_notice_text' ) ).'</p>';
                echo '</div>';
            echo '</div>';
        }
    echo '</header>';
}

// Lonyo Default Header
if( ! function_exists( 'lonyo_global_header' ) ){
    function lonyo_global_header(){
        // lonyo-body-visible
        // Mobile Menu
        echo '<div class="lonyo-menu-wrapper  ">';
            echo '<div class="lonyo-menu-area text-center">';
                echo '<div class="lonyo-menu-mobile-top">';
                    echo '<div class="mobile-logo">';
                        echo lonyo_theme_logo();
                    echo '</div>';
                    echo '<button class="lonyo-menu-toggle mobile"><i class="ri-close-line"></i></button>';
                echo '</div>';
                if( has_nav_menu( 'mobile-menu' ) ){
                    echo '<div class="lonyo-mobile-menu">';
                        wp_nav_menu( array(
                            "theme_location"    => 'mobile-menu',
                            "container"         => '',
                            "menu_class"        => ''
                        ) );
                    echo '</div>';
                }
            echo '</div>';
        echo '</div>';
    }
}


// lonyo woocommerce breadcrumb
function lonyo_woo_breadcrumb( $args ) {
    return array(
        'delimiter'   => '',
        'wrap_before' => '<div class="breadcumb-menu"><ul>',
        'wrap_after'  => '</ul></div>',
        'before'      => '<li>',
        'after'       => '</li>',
        'home'        => _x( 'Home', 'breadcrumb', 'lonyo' ),
    );
}

add_filter( 'woocommerce_breadcrumb_defaults', 'lonyo_woo_breadcrumb' );


function lonyo_custom_search_form( $class ) {
    echo '<!-- Search Form -->';
    echo '<form method="get" action="'.esc_url( home_url( '/' ) ).'" class="'.esc_attr( $class ).'">';
        echo '<label class="searchIcon">';
            echo '<input value="'.esc_html( get_search_query() ).'" name="s" required type="search" placeholder="'.esc_attr__('What are you looking for?', 'lonyo').'">';
        echo '</label>';
    echo '</form>';
    echo '<!-- End Search Form -->';
}



//Fire the wp_body_open action.
if ( ! function_exists( 'wp_body_open' ) ) {
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

//Remove Tag-Clouds inline style
add_filter( 'wp_generate_tag_cloud', 'lonyo_remove_tagcloud_inline_style',10,1 );
function lonyo_remove_tagcloud_inline_style( $input ){
   return preg_replace('/ style=("|\')(.*?)("|\')/','',$input );
}

// password protected form
add_filter('the_password_form','lonyo_password_form',10,1);
function lonyo_password_form( $output ) {
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post"><div class="theme-input-group">
        <input name="post_password" type="password" class="theme-input-style" placeholder="'.esc_attr__( 'Enter Password','lonyo' ).'">
        <button type="submit" class="submit-btn btn-fill">'.esc_html__( 'Enter','lonyo' ).'</button></div></form>';
    return $output;
}

function lonyo_setPostViews( $postID ) {
    $count_key  = 'post_views_count';
    $count      = get_post_meta( $postID, $count_key, true );
    if( $count == '' ){
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    }else{
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

function lonyo_getPostViews( $postID ){
    $count_key  = 'post_views_count';
    $count      = get_post_meta( $postID, $count_key, true );
    if( $count == '' ){
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return __( '0', 'lonyo' );
    }
    return $count;
}


/* This code filters the Categories archive widget to include the post count inside the link */
add_filter( 'wp_list_categories', 'lonyo_cat_remove_count_span' );
function lonyo_cat_remove_count_span( $links ) {
    $links = preg_replace('/<\/a> \([0-9]+\)/', '</a>', $links);
    return $links;
}

/* This code filters the Archive widget to include the post count inside the link */
add_filter( 'get_archives_link', 'lonyo_archive_remove_count' );
function lonyo_archive_remove_count( $links ) {
    $links = preg_replace('/<\/a>&nbsp;\([0-9]+\)/', '</a>', $links);
    return $links;
}

// Blog Category
if( ! function_exists( 'lonyo_blog_category' ) ){
    function lonyo_blog_category(){
        
        $lonyo_post_categories = get_the_category();
        if( is_array( $lonyo_post_categories ) && ! empty( $lonyo_post_categories ) ){
            if( is_single() ) {
                echo ' <a href="'.esc_url( get_term_link( $lonyo_post_categories[0]->term_id ) ).'"><i class="ri-bookmark-fill"></i>'.esc_html( $lonyo_post_categories[0]->name ).'</a> ';
            }else{
                echo ' <a href="'.esc_url( get_term_link( $lonyo_post_categories[0]->term_id ) ).'">'.esc_html( $lonyo_post_categories[0]->name ).'</a> ';
            }
                
        }
        
    }
}

// Add Extra Class On Comment Reply Button
function lonyo_custom_comment_reply_link( $content ) {
    $extra_classes = 'replay-btn';
    return preg_replace( '/comment-reply-link/', 'comment-reply-link ' . $extra_classes, $content);
}

add_filter('comment_reply_link', 'lonyo_custom_comment_reply_link', 99);

// Add Extra Class On Edit Comment Link
function lonyo_custom_edit_comment_link( $content ) {
    $extra_classes = 'replay-btn';
    return preg_replace( '/comment-edit-link/', 'comment-edit-link ' . $extra_classes, $content);
}

add_filter('edit_comment_link', 'lonyo_custom_edit_comment_link', 99);


function lonyo_post_classes( $classes, $class, $post_id ) {
    if ( get_post_type() === 'post' ) {
        if( ! is_single() ){
            if( lonyo_opt( 'lonyo_blog_style' ) == '3' ){
                $classes[] = "lonyo-blog blog-grid grid-wide";
            }else{
                $classes[] = "lonyo-blog blog-single";
            }
        }else{
            $classes[] = "lonyo-blog";
        }
    }elseif( get_post_type() === 'product' ){
        // Return Class
    }elseif( get_post_type() === 'page' ){
        $classes[] = "page--item";
    }

    return $classes;
}
add_filter( 'post_class', 'lonyo_post_classes', 10, 3 );
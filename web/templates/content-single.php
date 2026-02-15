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
        exit();
    }

    lonyo_setPostViews( get_the_ID() );

    ?>
    <div <?php post_class(); ?> >
    <?php
        

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

        // Blog Post Thumbnail
        do_action( 'lonyo_blog_post_thumb' );
        

        echo '<div class="blog-content">';

           
            // Blog Post Meta
            do_action( 'lonyo_blog_details_post_meta' );


            // Blog COntent
            the_content();
            // Link Pages
            lonyo_link_pages();

        echo '</div>';

        $lonyo_post_tag = get_the_tags();
        $blogtab = lonyo_opt('lonyo_blog_setting');
        if( class_exists('CSF') && !empty( $blogtab  ) ) {
            $lonyo_post_details_share_options = $blogtab[ 'lonyo_post_details_share_options'];
        } else {
            $lonyo_post_details_share_options = false;
        }

        if( ! empty( $lonyo_post_tag ) || ( function_exists( 'lonyo_social_sharing_buttons' ) && $lonyo_post_details_share_options ) ){
            echo '<!-- Share Links Area -->';
            echo '<div class="share-links">';
                echo '<div class="blog-details-social">';
                    if( function_exists( 'lonyo_social_sharing_buttons' ) && $lonyo_post_details_share_options ){
                        $lonyo_tag_col = "details-tag";
                    }else{
                        $lonyo_tag_col = "col-md-auto";
                    }
                    if( is_array( $lonyo_post_tag ) && ! empty( $lonyo_post_tag ) ){
                        echo '<div class="'.esc_attr( $lonyo_tag_col ).'">';
                            if( count( $lonyo_post_tag ) > 1 ){
                                $tag_text = __( 'Tags:', 'lonyo' );
                            }else{
                                $tag_text = __( 'Tag:', 'lonyo' );
                            }
                            echo '<div class="tagcloud">';
                                echo '<span class="tag-links-title">'.$tag_text.'</span>';
                                foreach( $lonyo_post_tag as $tags ){
                                    echo '<a href="'.esc_url( get_tag_link( $tags->term_id ) ).'">'.esc_html( $tags->name ).'</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    }
                    /**
                    *
                    * Hook for Blog Details Share Options
                    *
                    * Hook lonyo_blog_details_share_options
                    *
                    * @Hooked lonyo_blog_details_share_options_cb 10
                    *
                    */
                    do_action( 'lonyo_blog_details_share_options' );

                    echo '<!-- Share Links Area end -->';
                echo '</div>';
            echo '</div>';
        }
    echo '</div>';

    /**
    *
    * Hook for Blog Details Post Navigation Options
    *
    * Hook lonyo_blog_details_post_navigation
    *
    * @Hooked lonyo_blog_details_post_navigation_cb 10
    *
    */
    do_action( 'lonyo_blog_details_post_navigation' );

    /**
    *
    * Hook for Blog Details Author Bio
    *
    * Hook lonyo_blog_details_author_bio
    *
    * @Hooked lonyo_blog_details_author_bio_cb 10
    *
    */
    do_action( 'lonyo_blog_details_author_bio' );

    /**
    *
    * Hook for Blog Details Related Post
    *
    * Hook lonyo_blog_details_related_post
    *
    * @Hooked lonyo_blog_details_related_post_cb 10
    *
    */
    do_action( 'lonyo_blog_details_related_post' );

    /**
    *
    * Hook for Blog Details Comments
    *
    * Hook lonyo_blog_details_comments
    *
    * @Hooked lonyo_blog_details_comments_cb 10
    *
    */
    do_action( 'lonyo_blog_details_comments' );
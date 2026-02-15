<?php
/**
 * @Packge     : Onada
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://www.mthemeus.com/
 *
 */

    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit();
    }

    if( class_exists( 'CSF' )  ){

        $meta = get_post_meta( get_the_ID(), 'lonyo_page_meta_section', true );

        if( !empty( $meta['page_breadcrumb_area'] ) ) {
            $lonyo_page_breadcrumb_area  = $meta['page_breadcrumb_area'];
        } else {
            $lonyo_page_breadcrumb_area = '1';
        }
    }else{
        $lonyo_page_breadcrumb_area = '1';
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
        'sub'       => array(),
        'sup'       => array(),
    );

    if(  is_page() || is_page_template( 'template-builder.php' )  ) {
        if( $lonyo_page_breadcrumb_area == '1' ) {
            echo '<!-- Page title -->';
            echo '<div class="breadcumb-wrapper">';
                echo '<div class="container z-index-common">';
                    echo '<div class="breadcumb-content">';
                        if( class_exists('CSF') ) {
                            if( lonyo_opt('lonyo_page_title_switcher') == true ) {
                                $lonyo_page_title_switcher = lonyo_opt('lonyo_page_title_switcher');
                                
                            }else{
                                $lonyo_page_title_switcher = '1';
                            }
                        } else {
                            $lonyo_page_title_switcher = '1';
                        }

                        if( $lonyo_page_title_switcher == '1' ){
                            if( class_exists( 'CSF' ) ){
                                $lonyo_page_title_tag    = lonyo_opt('lonyo_page_title_tag');
                            }else{
                                $lonyo_page_title_tag    = 'h1';
                            }

                            if(  class_exists('CSF') ){
                                if( !empty( $meta['page_title_settings'] ) ) {
                                    $lonyo_custom_title = $meta['page_title_settings'];
                                } else {
                                    $lonyo_custom_title = 'default';
                                }
                            }else{
                                $lonyo_custom_title = 'default';
                            }

                            if( $lonyo_custom_title == 'default' ) {
                                echo lonyo_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $lonyo_page_title_tag ),
                                        "text"  => esc_html( get_the_title( ) ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } else {
                                echo lonyo_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $lonyo_page_title_tag ),
                                        "text"  => esc_html( $meta['custom_page_title'] ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            }

                        }
                        if( class_exists('CSF') ) {
                            $lonyo_breadcrumb_switcher = lonyo_opt( 'lonyo_enable_breadcrumb' );
                        } else {
                            $lonyo_breadcrumb_switcher = '1';
                        }
                        if( $lonyo_breadcrumb_switcher == '1' ) {
                            lonyo_breadcrumbs(
                                array(
                                    'breadcrumbs_classes' => 'nav',
                                )
                            );
                        }

                    echo '</div>';
                echo '</div>';
            echo '</div>';
            echo '<!-- End of Page title -->';
        }
    } else {
        echo '<!-- Page title -->';
        echo '<div class="breadcumb-wrapper">';
            echo '<div class="container z-index-common">';
                echo '<div class="breadcumb-content">';
                    if( class_exists( 'CSF' )  ){
                        $lonyo_page_title_switcher  = lonyo_opt('lonyo_page_title_switcher');
                    }else{
                        $lonyo_page_title_switcher = '1';
                    }

                    if( $lonyo_page_title_switcher ){
                        if( class_exists( 'CSF' ) ){
                            $lonyo_page_title_tag    = lonyo_opt('lonyo_page_title_tag');
                        }else{
                            $lonyo_page_title_tag    = 'h1';
                        }
                        if ( is_archive() ){
                            echo lonyo_heading_tag(
                                array(
                                    "tag"   => esc_attr( $lonyo_page_title_tag ),
                                    "text"  => wp_kses( get_the_archive_title(), $allowhtml ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }
                        elseif ( is_home() ){
                            // Fetch blog settings
                            $blogtab = lonyo_opt('lonyo_blog_setting');
                        
                            // Ensure $blogtab is an array and check if required keys exist
                            if( is_array( $blogtab ) ) {
                                $lonyo_blog_page_title_setting   = isset( $blogtab['lonyo_blog_page_title_setting'] ) ? $blogtab['lonyo_blog_page_title_setting'] : '';
                                $lonyo_blog_page_title_switcher  = isset( $blogtab['lonyo_blog_page_title_switcher'] ) ? $blogtab['lonyo_blog_page_title_switcher'] : false;
                                $lonyo_blog_page_custom_title    = isset( $blogtab['lonyo_blog_page_custom_title'] ) ? $blogtab['lonyo_blog_page_custom_title'] : '';
                        
                                if( class_exists('CSF') ){
                                    if( $lonyo_blog_page_title_switcher ){
                                        echo lonyo_heading_tag(
                                            array(
                                                "tag"   => esc_attr( isset( $lonyo_page_title_tag ) ? $lonyo_page_title_tag : 'h1' ),
                                                "text"  => !empty( $lonyo_blog_page_custom_title ) && $lonyo_blog_page_title_setting == 'custom' ? esc_html( $lonyo_blog_page_custom_title ) : esc_html__( 'Blog', 'lonyo' ),
                                                'class' => 'breadcumb-title'
                                            )
                                        );
                                    }
                                } else {
                                    // Fallback if CSF is not available
                                    echo lonyo_heading_tag(
                                        array(
                                            "tag"   => "h1",
                                            "text"  => esc_html__( 'Blog', 'lonyo' ),
                                            'class' => 'breadcumb-title',
                                        )
                                    );
                                }
                            } else {
                                // Fallback if $blogtab is not an array or doesn't contain the keys
                                echo lonyo_heading_tag(
                                    array(
                                        "tag"   => "h1",
                                        "text"  => esc_html__( 'Blog', 'lonyo' ),
                                        'class' => 'breadcumb-title',
                                    )
                                );
                            }
                        }

                        elseif( is_search() ){
                            echo lonyo_heading_tag(
                                array(
                                    "tag"   => esc_attr( $lonyo_page_title_tag ),
                                    "text"  => esc_html__( 'Search Result', 'lonyo' ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }elseif( is_404() ){
                            echo lonyo_heading_tag(
                                array(
                                    "tag"   => esc_attr( $lonyo_page_title_tag ),
                                    "text"  => esc_html__( '404 PAGE', 'lonyo' ),
                                    'class' => 'breadcumb-title'
                                )
                            );
                        }elseif( is_singular( 'lonyo_class' ) ){
                            echo lonyo_heading_tag(
                                array(
                                    "tag"   => "h1",
                                    "text"  => esc_html__( 'Class Details', 'lonyo' ),
                                    'class' => 'breadcumb-title',
                                )
                            );
                        }elseif( is_singular( 'lonyo_event' ) ){
                            echo lonyo_heading_tag(
                                array(
                                    "tag"   => "h1",
                                    "text"  => esc_html__( 'Event Details', 'lonyo' ),
                                    'class' => 'breadcumb-title',
                                )
                            );
                        }elseif( is_singular( 'lonyo_teacher' ) ){
                            echo lonyo_heading_tag(
                                array(
                                    "tag"   => "h1",
                                    "text"  => esc_html__( 'Teacher Details', 'lonyo' ),
                                    'class' => 'breadcumb-title',
                                )
                            );
                        }elseif( is_singular( 'product' ) ){
                            $posttitle_position  = lonyo_opt('lonyo_product_details_title_position');
                            $postTitlePos = false;
                            if( class_exists( 'CSF' ) ){
                                if( $posttitle_position && $posttitle_position != 'header' ){
                                    $postTitlePos = true;
                                }
                            }else{
                                $postTitlePos = false;
                            }
                            
                            if( $postTitlePos != true ){
                                echo lonyo_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $lonyo_page_title_tag ),
                                        "text"  => wp_kses( get_the_title( ), $allowhtml ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } 
                        }else{
                            $posttitle_position  = lonyo_opt('lonyo_post_details_title_position');
                            $postTitlePos = false;
                            if( is_single() ){
                                if( class_exists( 'CSF' ) ){
                                    if( $posttitle_position && $posttitle_position != 'header' ){
                                        $postTitlePos = true;
                                    }
                                }else{
                                    $postTitlePos = false;
                                }
                            }
                            if( is_singular( 'product' ) ){
                                $posttitle_position  = lonyo_opt('lonyo_product_details_title_position');
                                $postTitlePos = false;
                                if( class_exists( 'CSF' ) ){
                                    if( $posttitle_position && $posttitle_position != 'header' ){
                                        $postTitlePos = true;
                                    }
                                }else{
                                    $postTitlePos = false;
                                }
                            }

                            if( $postTitlePos != true ){
                                echo lonyo_heading_tag(
                                    array(
                                        "tag"   => esc_attr( $lonyo_page_title_tag ),
                                        "text"  => wp_kses( get_the_title( ), $allowhtml ),
                                        'class' => 'breadcumb-title'
                                    )
                                );
                            } 
                        }
                    }
                    if( class_exists('CSF') ) {
                        $lonyo_breadcrumb_switcher = lonyo_opt( 'lonyo_enable_breadcrumb' );
                    } else {
                        $lonyo_breadcrumb_switcher = '1';
                    }
                    if( $lonyo_breadcrumb_switcher == '1' ) {
                        lonyo_breadcrumbs(
                            array(
                                'breadcrumbs_classes' => 'nav',
                            )
                        );
                    }
                echo '</div>';
            echo '</div>';
        echo '</div>';
        echo '<!-- End of Page title -->';
    }
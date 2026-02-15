<?php
// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit();
}
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Lonyo
 * @Author URI : https://www.vecuro.com/
 *
 */

if( ! function_exists( 'lonyo_shop_categorysection_start_cb' ) ){
    function lonyo_shop_categorysection_start_cb(){
        // global $post;
        $terms = get_terms( array(
            'taxonomy'      => 'product_cat',
            'hide_empty'    => false,
        ) );
        if( $terms && class_exists( 'CSF' ) && lonyo_opt( 'lonyo_category_show_hide' ) ){
            echo '<section class="space-top arrow-wrap">';
                echo '<div class="container">';
                    echo '<div class="row category justify-content-between align-items-center lonyo-carousel arrow-margin" data-arrows="true" data-slide-show="6" data-ml-slide-show="6" data-lg-slide-show="5" data-md-slide-show="4" data-sm-slide-show="3" data-xs-slide-show="2">';
                        foreach ( $terms as $term ){
                            $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                            $catImg = wp_get_attachment_image_src( $thumbnail_id, 'full' );

                            echo '<div class="col-xl-2">';
                                echo '<div class="cat_rounded">';
                                    if ( $catImg && is_array( $catImg ) && ! empty( $catImg[0] ) ) {
                                        echo '<div class="cat-img">';
                                            echo '<a href="' . esc_url( get_term_link( $term ) ) . '">';
                                                echo lonyo_img_tag( array(
                                                    'url' => esc_url( $catImg[0] )
                                                ) );
                                            echo '</a>';
                                        echo '</div>';
                                    }
                                    echo '<h3 class="cat-name"><a class="text-inherit" href="'.esc_url( get_term_link( $term ) ).'">'.esc_html( $term->name ).'</a></h3>';
                                echo '</div>';
                            echo '</div>';

                        }
                    echo '</div>';
                echo '</div>';
            echo '</section>';
        }
    }
}

// lonyo shop main content hook functions
if( !function_exists('lonyo_shop_main_content_cb') ) {
    function lonyo_shop_main_content_cb( ) {

       

        if( is_shop() || is_product_category() || is_product_tag() ) {

            $wctab = lonyo_opt('lonyo_wc_settings');
          
            if( !empty(  $wctab["lonyo_shop_bg"] ) ){
                $lonyo_shop_bg_image =  $wctab["lonyo_shop_bg"];
                $url = $lonyo_shop_bg_image['url'];
            }else{
                $url = '';
            }
            
            echo '<section class="lonyo-product-wrapper lonyo-section-padding background-image" style="background-image: url('. $url .')">';
                 echo '<div class="container">';
            if( class_exists('CSF') ) {
                $lonyo_woo_product_col = lonyo_opt('lonyo_woo_product_col');
                if( $lonyo_woo_product_col == '2' ) {
                    echo '<div class="container">';
                } elseif( $lonyo_woo_product_col == '3' ) {
                    echo '<div class="container">';
                } elseif( $lonyo_woo_product_col == '4' ) {
                    echo '<div class="container">';
                } elseif( $lonyo_woo_product_col == '5' ) {
                    echo '<div class="lonyo-container">';
                } elseif( $lonyo_woo_product_col == '6' ) {
                    echo '<div class="lonyo-container">';
                }
            } else {
                echo '<div class="container">';
            }
        } else {
            echo '<section class="lonyo-product-wrapper lonyo-section-padding product-details">';
                echo '<div class="container">';
        }
            echo '<div class="row">';
    }
}

// lonyo shop main content hook function
if( !function_exists('lonyo_shop_main_content_end_cb') ) {
    function lonyo_shop_main_content_end_cb( ) {
                echo '</div>';
             echo '</div>';
        echo '</div>';
    echo '</section>';
    }
}

// shop column start hook function
if( !function_exists('lonyo_shop_col_start_cb') ) {
    function lonyo_shop_col_start_cb( ) {
        if( class_exists('CSF') ) {
            if( class_exists('woocommerce') && is_shop() ) {
                $wctab = lonyo_opt('lonyo_wc_settings');
                $lonyo_woo_shoppage_sidebar = is_array($wctab) && isset($wctab['lonyo_woo_shoppage_sidebar']) ? $wctab['lonyo_woo_shoppage_sidebar'] : '';
                if( $lonyo_woo_shoppage_sidebar == '2' && is_active_sidebar('lonyo-woo-sidebar') ) {
                    echo '<div class="col-lg-8 col-xl-9 order-last">';
                } elseif( $lonyo_woo_shoppage_sidebar == '3' && is_active_sidebar('lonyo-woo-sidebar') ) {
                    echo '<div class="col-lg-8 col-xl-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }
            } else {
                echo '<div class="col-lg-12">';
            }
        } else {
            if( class_exists('woocommerce') && is_shop() ) {
                if( is_active_sidebar('lonyo-woo-sidebar') ) {
                    echo '<div class="col-lg-8 col-xl-9">';
                } else {
                    echo '<div class="col-lg-12">';
                }
            } else {
                echo '<div class="col-lg-12">';
            }
        }

    }
}

// shop column end hook function
if( !function_exists('lonyo_shop_col_end_cb') ) {
    function lonyo_shop_col_end_cb( ) {
        echo '</div>';
    }
}

// lonyo woocommerce pagination hook function
if( ! function_exists('lonyo_woocommerce_pagination') ) {
    function lonyo_woocommerce_pagination( ) {
        if( ! empty( lonyo_pagination() ) ) {
            echo '<div class="row">';
                echo '<div class="col-12">';
                    echo '<div class="lonyo-pagination">';
                        add_filter('next_posts_link_attributes', 'woo_posts_link_attributes');
                        add_filter('previous_posts_link_attributes', 'woo_posts_link_attributes');
                        function woo_posts_link_attributes(){
                            return 'class="pagi-btn"';
                        };
                        $prev 	= '<i class="ri-arrow-left-s-line"></i>';
                        $next 	= '<i class="ri-arrow-right-s-line"></i>';
                        // previous
                        if( get_previous_posts_link() ){
                            previous_posts_link( $prev );
                        }
                        echo '<ul>';
                            echo lonyo_pagination();
                        echo '</ul>';
                        // next
                        if( get_next_posts_link() ){
                            next_posts_link( $next );
                        }
                        
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}

// woocommerce filter wrapper hook function
if( ! function_exists('lonyo_woocommerce_filter_wrapper') ) {
    function lonyo_woocommerce_filter_wrapper( ) {
        echo '<div class="lonyo-sort-bar">';
            echo '<div class="row justify-content-between align-items-center">';
                echo '<div class="col-md-auto">';
                    echo '<p class="woocommerce-result-count">'.woocommerce_result_count().'</p>';
                echo '</div>';
                echo '<div class="col-md-auto">';
                    echo '<div class="col-sm-auto">';
                        echo woocommerce_catalog_ordering();
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}

// woocommerce tab content wrapper start hook function
if( ! function_exists('lonyo_woocommerce_tab_content_wrapper_start') ) {
    function lonyo_woocommerce_tab_content_wrapper_start( ) {
        echo '<!-- Tab Content -->';
        echo '<div class="tab-content" id="nav-tabContent">';
    }
}

// woocommerce tab content wrapper start hook function
if( ! function_exists('lonyo_woocommerce_tab_content_wrapper_end') ) {
    function lonyo_woocommerce_tab_content_wrapper_end( ) {
        echo '</div>';
        echo '<!-- End Tab Content -->';
    }
}
// lonyo grid tab content hook function
if( !function_exists('lonyo_grid_tab_content_cb') ) {
    function lonyo_grid_tab_content_cb( ) {
        echo '<!-- Grid -->';
            echo '<div class="tab-pane fade show active" id="tab-grid" role="tabpanel" aria-labelledby="tab-shop-grid">';
                woocommerce_product_loop_start();
                if( class_exists('CSF') ) {
                    $wctab = lonyo_opt('lonyo_wc_settings');
                    $lonyo_woo_product_col = ( is_array($wctab) && isset($wctab['lonyo_woo_product_col']) ) ? $wctab['lonyo_woo_product_col'] : '4';
                    if( $lonyo_woo_product_col == '2' ) {
                        $lonyo_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-6';
                    } elseif( $lonyo_woo_product_col == '3' ) {
                        $lonyo_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-4';
                    } elseif( $lonyo_woo_product_col == '4' ) {
                        $lonyo_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-3';
                    } elseif( $lonyo_woo_product_col == '6' ) {
                        $lonyo_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-2';
                    }
                } else {
                    $lonyo_woo_product_col_val = 'col-sm-6 col-md-6 col-lg-6 col-xl-3';
                }

                if ( wc_get_loop_prop( 'total' ) ) {
                    while ( have_posts() ) {
                        the_post();

                        echo '<div class="'.esc_attr( $lonyo_woo_product_col_val ).'">';
                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );

                        echo '</div>';
                    }
                    wp_reset_postdata();
                }

                woocommerce_product_loop_end();
            echo '</div>';
        echo '<!-- End Grid -->';
    }
}

// lonyo list tab content hook function
if( !function_exists('lonyo_list_tab_content_cb') ) {
    function lonyo_list_tab_content_cb( ) {
        echo '<!-- List -->';
        echo '<div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-shop-list">';
            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();
                    echo '<div class="col-sm-6 col-lg-6 col-xl-4">';
                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content-horizontal', 'product' );
                    echo '</div>';
                }
                wp_reset_postdata();
            }

            woocommerce_product_loop_end();
        echo '</div>';
        echo '<!-- End List -->';
    }
}

// lonyo woocommerce get sidebar hook function
if( ! function_exists('lonyo_woocommerce_get_sidebar') ) {
    function lonyo_woocommerce_get_sidebar( ) {
        if( class_exists('CSF') ) {
            $wctab = lonyo_opt('lonyo_wc_settings');
            $lonyo_woo_shoppage_sidebar = is_array( $wctab ) && isset( $wctab['lonyo_woo_shoppage_sidebar'] ) ? $wctab['lonyo_woo_shoppage_sidebar'] : '1'; 
        } else {
            if( is_active_sidebar('lonyo-woo-sidebar') ) {
                $lonyo_woo_shoppage_sidebar = '2';
            } else {
                $lonyo_woo_shoppage_sidebar = '1';
            }
        }

        if( is_shop() ) {
            if( $lonyo_woo_shoppage_sidebar != '1' ) {
                get_sidebar('shop');
            }
        }
    }
}

// lonyo loop product thumbnail hook function
if( !function_exists('lonyo_loop_product_thumbnail') ) {
    function lonyo_loop_product_thumbnail( ) {
        global $product;

        echo '<div class="product-img">';
            echo '<div class="product-extra-things">';
                if( $product->is_on_sale() && $product->get_type() == 'simple' ) {
                    echo '<div class="onsale product-label">'.esc_html__( 'Sale', 'lonyo' ).'</div>';
                }
                if( $product->is_featured() ) {
                    echo '<div class="featured woocommerce-badge product-label">'.esc_html__( 'Hot', 'lonyo' ).'</div>';
                }
                if( ! $product->is_in_stock() ) {
                    echo '<div class="outofstock woocommerce-badge product-label">'.esc_html__( 'Stock Out', 'lonyo' ).'</div>';
                }
            echo '</div>';

            if( has_post_thumbnail() ){
                echo '<a href="'.esc_url( get_permalink() ).'">';
                    the_post_thumbnail();
                echo '</a>';
            }
            // Product bottom
            echo '<div class="actions">';
                // Cart Button
                woocommerce_template_loop_add_to_cart_text_style();
                // Wishlist Button
                if( class_exists( 'TInvWL_Admin_TInvWL' ) ){
                    echo do_shortcode( '[ti_wishlists_addtowishlist]' );
                }
            echo '</div>';
        echo '</div>';
    }
}

// shop loop product summary
if( ! function_exists('lonyo_loop_product_summary') ) {
    function lonyo_loop_product_summary( ) {
        global $product;
        echo '<div class="product-content">';
            // Product Title
            echo '<h3 class="product-title">
                <a class="text-inherit" href="'.esc_url( get_permalink() ).'">'.esc_html( get_the_title() ).'</a>
            </h3>';
            echo woocommerce_template_loop_rating();

            // Product Price
            echo '<div class="product-price">';
                echo woocommerce_template_loop_price();
            echo '</div>';
        echo '</div>';
    }
}

// shop loop horizontal product summary
if( ! function_exists( 'lonyo_horizontal_loop_product_summary' ) ) {
    function lonyo_horizontal_loop_product_summary() {
        global $product;
        echo '<div class="product-content">';
            echo '<div>';
                // Product Title
                echo '<h4 class="product-title h5"><a href="'.esc_url( get_permalink() ).'">'.esc_html( get_the_title() ).'</a></h4>';
                // Product Price
                echo woocommerce_template_loop_price();
                // Product Rating
                woocommerce_template_loop_rating();

            echo '</div>';
        echo '</div>';
    }
}

// single product price rating hook function
if( !function_exists('lonyo_woocommerce_single_product_price_rating') ) {
    function lonyo_woocommerce_single_product_price_rating() {
        
        
        echo '<!-- Product Prices -->';
        woocommerce_template_single_price();
        echo '<!-- End Product Price -->';
       
    }
}

// single product title hook function
if( !function_exists('lonyo_woocommerce_single_product_title') ) {
    function lonyo_woocommerce_single_product_title( ) {
        if( class_exists( 'CSF' ) ) {
            $wctab = lonyo_opt('lonyo_wc_settings');
            $producttitle_position = $wctab['lonyo_product_details_title_position'];
        } else {
            $producttitle_position = 'header';
        }

        if( $producttitle_position != 'header' ) {
            echo '<!-- Product Title -->';
            echo '<h2 class="product-title">'.esc_html( get_the_title() ).'</h2>';
            echo '<!-- End Product Title -->';
        }

        global $product;
        // Product Rating
        echo '<div class="product-rating">';
            $average_rating = $product->get_average_rating();
            $review_count   = $product->get_review_count();
            if( $review_count == '0' ){
                esc_html_e( 'There are no reviews yet', 'lonyo' );
            }else{
                woocommerce_template_loop_rating();
                if( $review_count > 1 ) {
                    esc_html_e('Reviews','lonyo');
                } else {
                    esc_html_e('Review','lonyo');
                };
                echo '<span class="count">'.esc_html( ' ('.$review_count ).')'.' </span> ';
            }
        echo '</div>';
       

    }
}

// single product title hook function
if( !function_exists('lonyo_woocommerce_quickview_single_product_title') ) {
    function lonyo_woocommerce_quickview_single_product_title( ) {
        echo '<!-- Product Title -->';
        echo '<h2 class="product-title">'.esc_html( get_the_title() ).'</h2>';
        echo '<!-- End Product Title -->';
    }
}

// single product excerpt hook function
if( !function_exists('lonyo_woocommerce_single_product_excerpt') ) {
    function lonyo_woocommerce_single_product_excerpt( ) {
        echo '<!-- Product Description -->';
        woocommerce_template_single_excerpt();
        echo '<!-- End Product Description -->';
    }
}

// single product availability hook function
if( !function_exists('lonyo_woocommerce_single_product_availability') ) {
    function lonyo_woocommerce_single_product_availability( ) {
        global $product;
        $availability = $product->get_availability();

        if( class_exists( 'CSF' ) ){
            $wctab = lonyo_opt('lonyo_wc_settings');
            $lonyo_stock_quantity = $wctab['lonyo_woo_stock_quantity_show_hide'];
        }else{
            $lonyo_stock_quantity = 1;
        }

        if( $lonyo_stock_quantity ){
            if( $availability['class'] != 'out-of-stock' ) {
                echo '<!-- Product Availability -->';
                    echo '<div class="mt-2 link-inherit fs-xs">';
                        echo '<p>';
                            echo '<strong class="text-title me-3 font-theme">'.esc_html__( 'Availability:', 'lonyo' ).'</strong>';
                            if( $product->get_stock_quantity() ){
                                echo '<span class="stock in-stock"><i class="far fa-check-square me-2"></i>'.esc_html( $product->get_stock_quantity() ).'</span>';
                            }else{
                                echo '<span class="stock in-stock"><i class="far fa-check-square me-2"></i>'.esc_html__( 'In Stock', 'lonyo' ).'</span>';
                            }
                        echo '</p>';
                    echo '</div>';
                echo '<!--End Product Availability -->';
            } else {
                echo '<!-- Product Availability -->';
                echo '<div class="mt-2 link-inherit fs-xs">';
                    echo '<p>';
                        echo '<strong class="text-title me-3 font-theme">'.esc_html__( 'Availability:', 'lonyo' ).'</strong>';
                        echo '<span class="stock out-of-stock"><i class="far fa-check-square me-2"></i>'.esc_html__( 'Out Of Stock', 'lonyo' ).'</span>';
                    echo '</p>';
                echo '</div>';
                echo '<!--End Product Availability -->';
            }
        }
    }
}

// single product add to cart fuunction
if( !function_exists('lonyo_woocommerce_single_add_to_cart_button') ) {
    function lonyo_woocommerce_single_add_to_cart_button( ) {
        woocommerce_template_single_add_to_cart();
    }
}

// single product ,eta hook function
if( !function_exists('lonyo_woocommerce_single_meta') ) {
    function lonyo_woocommerce_single_meta( ) {
        global $product;
        echo '<div class="product_meta">';
            echo '<h4>'.esc_html__( 'Quick info', 'lonyo' ).'</h4>';
            if( ! empty( $product->get_sku() ) ){
                echo '<span class="sku_wrapper">'.esc_html__( 'SKU: ', 'lonyo' ).'<span class="sku">' .$product->get_sku().'</span></span>';
            }
            echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'lonyo' ) . ' ', '</span>' );
            // Add the "Tags" section here
            $product_tags = get_the_terms( $product->get_id(), 'product_tag' );
            if ( $product_tags && ! is_wp_error( $product_tags ) ) {
                echo '<span>' . esc_html__( 'Tags:', 'lonyo' ) . ' ';
                $tag_links = array();
                foreach ( $product_tags as $tag ) {
                    $tag_links[] = '<a href="' . get_term_link( $tag ) . '" rel="tag">' . esc_html( $tag->name ) . '</a>';
                }
                echo implode( ', ', $tag_links );
                echo '</span>';
            }
        echo '</div>';

        
        
    }
}

// single produt sidebar hook function
if( !function_exists('lonyo_woocommerce_single_product_sidebar_cb') ) {
    function lonyo_woocommerce_single_product_sidebar_cb(){
        if( class_exists('CSF') ) {
            $wctab = lonyo_opt('lonyo_wc_settings');
            $lonyo_woo_singlepage_sidebar = $wctab['lonyo_woo_singlepage_sidebar'];
            if( ( $lonyo_woo_singlepage_sidebar == '2' || $lonyo_woo_singlepage_sidebar == '3' ) && is_active_sidebar('lonyo-woo-sidebar') ) {
                get_sidebar('shop');
            }
        } else {
            if( is_active_sidebar('lonyo-woo-sidebar') ) {
                get_sidebar('shop');
            }
        }
    }
}

// reviewer meta hook function
if( !function_exists('lonyo_woocommerce_reviewer_meta') ) {
    function lonyo_woocommerce_reviewer_meta( $comment ){
        $verified = wc_review_is_from_verified_owner( $comment->comment_ID );
        if ( '0' === $comment->comment_approved ) { ?>
            <em class="woocommerce-review__awaiting-approval">
                <?php esc_html_e( 'Your review is awaiting approval', 'lonyo' ); ?>
            </em>

        <?php } else { ?>
                <h4 class="name h4"><?php echo ucwords( get_comment_author() ); ?> </h4>
                
                <span class="commented-on "><time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"> <?php printf( esc_html__('%1$s at %2$s', 'lonyo'), get_comment_date(wc_date_format()),  get_comment_time() ); ?> </time></span>
           
                <?php
                if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
                    echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'lonyo' ) . ')</em> ';
                }

                ?>
        <?php
        }

        woocommerce_review_display_rating();
    }
}

// woocommerce proceed to checkout hook function
if( !function_exists('lonyo_woocommerce_button_proceed_to_checkout') ) {
    function lonyo_woocommerce_button_proceed_to_checkout() {
        echo '<a href="'.esc_url( wc_get_checkout_url() ).'" class="checkout-button button alt wc-forward lonyo-btn lonyo-default-btn btn-style"  data-text="Proceed to checkout">';
            echo '<span class="btn-wraper">';
                esc_html_e( 'Proceed to checkout', 'lonyo' );
            echo '</span>';
        echo '</a>';
    }
}

// lonyo woocommerce cross sell display hook function
if( !function_exists('lonyo_woocommerce_cross_sell_display') ) {
    function lonyo_woocommerce_cross_sell_display( ){
        woocommerce_cross_sell_display();
    }
}

// lonyo minicart view cart button hook function
if( !function_exists('lonyo_minicart_view_cart_button') ) {
    function lonyo_minicart_view_cart_button() {
        echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button checkout wc-forward lonyo-btn style1">' . esc_html__( 'View cart', 'lonyo' ) . '</a>';
    }
}

// lonyo minicart checkout button hook function
if( !function_exists('lonyo_minicart_checkout_button') ) {
    function lonyo_minicart_checkout_button() {
        echo '<a href="' .esc_url( wc_get_checkout_url() ) . '" class="button wc-forward lonyo-btn style1">' . esc_html__( 'Checkout', 'lonyo' ) . '</a>';
    }
}

// lonyo woocommerce before checkout form
if( !function_exists('lonyo_woocommerce_before_checkout_form') ) {
    function lonyo_woocommerce_before_checkout_form() {
        echo '<div class="row">';
            if ( ! is_user_logged_in() && 'yes' === get_option('woocommerce_enable_checkout_login_reminder') ) {
                echo '<div class="col-lg-12">';
                    woocommerce_checkout_login_form();
                echo '</div>';
            }

            echo '<div class="col-lg-12">';
                woocommerce_checkout_coupon_form();
            echo '</div>';
        echo '</div>';
    }
}

// add to cart button
function woocommerce_template_loop_add_to_cart( $args = array() ) {
    global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'icon-btn',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = wp_parse_args( $args, $defaults );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
            }
        }

        echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'cart-button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            '<i class="far fa-shopping-cart"></i>'
        );
}

// add to cart button Text
function woocommerce_template_loop_add_to_cart_text_style( $args = array() ) {
    global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'lonyo-btn',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = wp_parse_args( $args, $defaults );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
            }
        }

        echo sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s %s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'cart-button' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            '',
            esc_html__( 'Add to Cart', 'lonyo' ),
            
        );
}

// product searchform
add_filter( 'get_product_search_form' , 'lonyo_custom_product_searchform' );
function lonyo_custom_product_searchform( $form ) {

    $form = '<form class="search-form" method="get" action="' . esc_url( home_url( '/'  ) ) . '">
        <label class="screen-reader-text" for="s">' . __( 'Search for:', 'lonyo' ) . '</label>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search', 'lonyo' ) . '" />
        <button class="submit-btn" type="submit"><i class="far fa-eye"></i></button>
        <input type="hidden" name="post_type" value="product" />
    </form>';

    return $form;
}

// cart empty message
add_action('woocommerce_cart_is_empty','lonyo_wc_empty_cart_message',10);
function lonyo_wc_empty_cart_message( ) {
    echo '<h3 class="cart-empty d-none">'.esc_html__('Your cart is currently empty.','lonyo').'</h3>';
}

// woocommerce single product title
function lonyo_woocommerce_single_product_title() {
    echo '<h1 class="product_title entry-title">' . get_the_title() . '</h1>';
}

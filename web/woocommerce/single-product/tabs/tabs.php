<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 10.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback, and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

        
        <!-- End Tab Buttons -->
        <!-- Tab Content -->
        <div class="col-12">
            <div class="product-desc-wrap">

                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    <?php
                    $tabcontentcount = 1;
                    foreach ( $tabs as $key => $tab ) : 
                        // Set the active class for the first tab
                        $active_class = ( $tabcontentcount === 1 ) ? 'active' : '';
                    ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo $active_class; ?>" id="<?php echo esc_attr( $key . '-tab' ); ?>" data-bs-toggle="tab" data-bs-target="#<?php echo esc_attr( $key . '-tab-pane' ); ?>" type="button" role="tab" aria-controls="<?php echo esc_attr( $key . '-tab-pane' ); ?>" aria-selected="true">
                                <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
                            </button>
                        </li>
                    <?php 
                        $tabcontentcount++;
                    endforeach;
                    ?>
                </ul>

                <div class="tab-content" id="myTabContent2">
                    <?php
                    $tabcontentcount = 1;
                    foreach ( $tabs as $key => $tab ) :
                        // Set the active class for the first tab pane
                        $active_class = ( $tabcontentcount === 1 ) ? 'show active' : 'fade';
                    ?>
                        <div class="tab-pane fade <?php echo $active_class; ?>" id="<?php echo esc_attr( $key . '-tab-pane' ); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr( $key . '-tab' ); ?>" tabindex="0">
                            <?php if ( isset( $tab['callback'] ) ) { call_user_func( $tab['callback'], $key, $tab ); } ?>
                        </div>

                    <?php 
                        $tabcontentcount++;
                    endforeach;
                    ?>
                </div>




            </div>
        </div>

<?php endif; ?>
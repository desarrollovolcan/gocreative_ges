<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 10.0.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );
echo '<div class="d-flex justify-content-center">';
    echo '<div class="empty_cart text-center">';
if ( wc_get_page_id( 'shop' ) > 0 ) :
        echo lonyo_img_tag( array(
            'url'   => esc_url( get_theme_file_uri( '/assets/img/empty-cart.png' ) )
        ) );
        echo '<h3 class="pt-5 pb-5">'.esc_html__('Your cart is currently empty.','lonyo').'</h3>';
        ?>
		<a class="button wc-backward lonyo-btn mask-style2 lonyo-default-btn btn-style" data-text="Return to shop" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            <span class="btn-wraper">
			    <?php esc_html_e( 'Return to shop', 'lonyo' ); ?>
            </span>
		</a>
<?php endif; ?>
    </div>
</div>

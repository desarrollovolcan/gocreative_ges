<?php
/**
 * Related Products
 *
 * Template override for Lonyo theme.
 * @version 10.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get theme options
$wctab = function_exists('lonyo_opt') ? lonyo_opt('lonyo_wc_settings') : [];

$lonyo_woo_relproduct_display     = $wctab['lonyo_woo_relproduct_display'] ?? true;
$lonyo_woo_related_product_col    = $wctab['lonyo_woo_related_product_col'] ?? '4';
$lonyo_woo_relproduct_num         = $wctab['lonyo_woo_relproduct_num'] ?? 4;

// Stop if hidden
if ( ! $lonyo_woo_relproduct_display ) {
	return;
}

// If WooCommerce didn't pass $related_products, try getting manually
if ( ! isset($related_products) || empty($related_products) ) {
	$related_products = wc_get_related_products( get_the_ID(), $lonyo_woo_relproduct_num );
}

// Fallback: Get products from same category
if ( empty($related_products) ) {
	$terms = wp_get_post_terms( get_the_ID(), 'product_cat', ['fields' => 'ids'] );
	if ( ! empty($terms) ) {
		$query = new WP_Query([
			'post_type'      => 'product',
			'posts_per_page' => $lonyo_woo_relproduct_num,
			'post__not_in'   => [ get_the_ID() ],
			'tax_query'      => [
				[
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $terms,
				],
			],
			'fields' => 'ids',
		]);
		$related_products = $query->posts;
		wp_reset_postdata();
	}
}

if ( ! empty($related_products) ) :
	$heading = apply_filters( 'woocommerce_product_related_products_heading', esc_html__( 'Related products', 'lonyo' ) );
	$col_class = 'col-md-6 col-lg-' . ( 12 / (int) $lonyo_woo_related_product_col );
	?>

	<div class="container">
		<?php if ( $heading ) : ?>
			<h2 class="sec-subtitle3"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div class="row related-product lonyo-carousel"
			data-slide-show="<?php echo esc_attr($lonyo_woo_relproduct_num); ?>"
			data-lg-slide-show="3"
			data-md-slide-show="2">

			<?php foreach ( $related_products as $product_id ) :
				$post_object = get_post( $product_id );
				setup_postdata( $GLOBALS['post'] =& $post_object );
				?>
				<div class="<?php echo esc_attr($col_class); ?>">
					<?php wc_get_template_part( 'content', 'product' ); ?>
				</div>
			<?php endforeach; ?>

		</div>
	</div>

<?php endif;

wp_reset_postdata();

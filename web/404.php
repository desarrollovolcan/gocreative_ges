<?php
/**
 * @Packge     : Onada
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://www.mthemeus.com/
 */

// Block direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit();
}

if ( class_exists( 'CSF' ) ) {
    $lonyo404title     = lonyo_opt( 'lonyo_fof_title' );
    $lonyo404subtitle  = lonyo_opt( 'lonyo_fof_subtitle' );
    $lonyo404btntext   = lonyo_opt( 'lonyo_fof_btn_text' );
} else {
    $lonyo404title     = __( 'Page not found', 'lonyo' );
    $lonyo404subtitle  = __( 'Oops! The page you\'re trying to access has been relocated, given a new name, or is currently unavailable.', 'lonyo' );
    $lonyo404btntext   = __( 'Back to Home', 'lonyo' );
}

// get header
get_header();


?>

<div class="lonyo-error-section">
    <div class="container">
        <div class="lonyo-error-content" data-aos="fade-up" data-aos-duration="700">
            <?php 
                $error_main_img = '';
                if ( ! empty( lonyo_opt('lonyo_error_image') ) ) {
                    $main_img_array = lonyo_opt('lonyo_error_image');
                    $error_main_img = isset($main_img_array['url']) ? $main_img_array['url'] : '';
                }

                if ( ! empty( $error_main_img ) ) {
                    echo '<div class="lonyo-error-thumb aos-init aos-animate" data-aos="fade-up" data-aos-duration="700">';
                        echo '<img src="' . esc_url( $error_main_img ) . '" alt="404">';
                    echo '</div>';
                } else {
                    echo '<h3>404</h3>';
                }
            ?>

            <?php if ( ! empty( $lonyo404title ) ) : ?>
                <h1><?php echo esc_html( $lonyo404title ); ?></h1>
            <?php endif; ?>
            <?php if ( ! empty( $lonyo404subtitle ) ) : ?>
                <p><?php echo esc_html( $lonyo404subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $lonyo404btntext ) ) : ?>
                <a class="lonyo-default-btn btn-style" href="<?php echo esc_url( home_url( '/' ) ); ?>" data-text="<?php echo esc_html( $lonyo404btntext ); ?>">
					<span class="btn-wraper">
						<?php echo esc_html( $lonyo404btntext ); ?>					
                    </span>
				</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// get footer
get_footer();

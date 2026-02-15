<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */

// Block direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
    /**
    *
    * Hook for Footer Content
    *
    * Hook lonyo_footer_content
    *
    * @Hooked lonyo_footer_content_cb 10
    *
    */
    do_action( 'lonyo_footer_content' );

    if( !is_404( ) ) {
        /**
        *
        * Hook for Back to Top Button
        *
        * Hook lonyo_back_to_top
        *
        * @Hooked lonyo_back_to_top_cb 10
        *
        */
        do_action( 'lonyo_back_to_top' );
    }

    wp_footer();
    ?>
</body>
</html>
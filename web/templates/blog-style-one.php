<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */

// Block direct access
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

echo '<!-- Single Post -->';
?>
<div <?php post_class(); ?> >
<?php

    // Blog Post Thumbnail
    do_action( 'lonyo_blog_post_thumb' );
    // Blog Post Content
    do_action( 'lonyo_blog_post_content' );
    
echo '</div>';
echo '<!-- End Single Post -->';
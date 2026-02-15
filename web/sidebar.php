<?php

/**
 * @Packge     : Infinix
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */


// Block direct access
if( !defined( 'ABSPATH' ) ){
    exit;
}

if ( ! is_active_sidebar( 'lonyo-blog-sidebar' ) ) {
    return;
}

$blogtab = lonyo_opt('lonyo_blog_setting');

if (is_array($blogtab)) {
    $lonyo_blog_sidebar = $blogtab['lonyo_blog_sidebar'] ?? null;
    $lonyo_single_sidebar = $blogtab['lonyo_blog_single_sidebar'] ?? null;
} else {
    // Handle the case where $blogtab is not an array
    $lonyo_blog_sidebar = null;
    $lonyo_single_sidebar = null;
}


$lonyo_page_sidebar = lonyo_opt('lonyo_page_sidebar');
if ( is_single() ) {
    if ('1' === $lonyo_single_sidebar) {
		return;
	}
} elseif( is_page() ) {
    if ('1' === $lonyo_page_sidebar) {
		return;
	}
} else {
    if ('1' === $lonyo_blog_sidebar) {
		return;
	}
}
?>

<div class="col-lg-4">
    <div class="sidebar-area sticky-sidebar">
    <?php dynamic_sidebar( 'lonyo-blog-sidebar' ); ?>
    </div>
</div>
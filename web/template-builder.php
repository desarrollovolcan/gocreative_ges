<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( );
}
/**
 * @Packge    : Lonyo
 * @version   : 1.0
 * @Author    : Mthemeus
 * @Author URI: https://mthemeus.com/
 * Template Name: Template Builder
 */

//Header
get_header();

// Container or wrapper div
$meta = get_post_meta( get_the_ID(), 'lonyo_page_layout_section', true );
$lonyo_layout = $meta ['custom_page_layout'];

if( $lonyo_layout == '1' ){
	echo '<div class="lonyo-main-wrapper">';
		echo '<div class="container">';
			echo '<div class="row">';
				echo '<div class="col-sm-12">';
}elseif( $lonyo_layout == '2' ){
    echo '<div class="lonyo-main-wrapper">';
		echo '<div class="container-fluid">';
			echo '<div class="row">';
				echo '<div class="col-sm-12">';
}else{
	echo '<div class="lonyo-fluid">';
}
	echo '<div class="builder-page-wrapper">';
	// Query
	if( have_posts() ){
		while( have_posts() ){
			the_post();
			the_content();
		}
        wp_reset_postdata();
	}

	echo '</div>';
if( $lonyo_layout == '1' ){
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}elseif( $lonyo_layout == '2' ){
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}else{
	echo '</div>';
}

//footer
get_footer();
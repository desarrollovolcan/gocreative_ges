<?php
	// Block direct access
	if( ! defined( 'ABSPATH' ) ){
		exit( );
	}
	/**
	* @Packge 	   : Lonyo
	* @Version     : 1.0
	* @Author     : Mthemeus
    * @Author URI : https://mthemeus.com/
	*
	*/

	if( ! is_active_sidebar( 'lonyo-woo-sidebar' ) ){
		return;
	}
?>
<div class="col-lg-4 col-xl-3">
	<!-- Sidebar Begin -->
	<aside class="sidebar-area shop-sidebar">
		<?php
			dynamic_sidebar( 'lonyo-woo-sidebar' );
		?>
	</aside>
	<!-- Sidebar End -->
</div>
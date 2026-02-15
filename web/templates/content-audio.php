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

if( class_exists( 'CSF' ) ){
    get_template_part( 'templates/blog-style-one' );
}else{
    get_template_part( 'templates/blog-style-one' );
}
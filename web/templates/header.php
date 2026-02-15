<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */

    // Block direct access
    if( ! defined( 'ABSPATH' ) ){
        exit();
    }

    if (defined('ELEMENTOR_PRO_VERSION')) {
        return;
    } else {
        lonyo_global_header_option();
    }
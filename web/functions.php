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
 * Include File
 *
 */

// Constants
require_once get_parent_theme_file_path() . '/inc/lonyo-constants.php';

//theme setup
require_once LONYO_DIR_PATH_INC . 'theme-setup.php';

//essential scripts
require_once LONYO_DIR_PATH_INC . 'essential-scripts.php';

if( class_exists( 'WooCommerce' ) ){
    // Woo Hooks
    require_once LONYO_DIR_PATH_INC . 'woo-hooks/lonyo-woo-hooks.php';

    // Woo Hooks Functions
    require_once LONYO_DIR_PATH_INC . 'woo-hooks/lonyo-woo-hooks-functions.php';
}

// plugin activation
require_once LONYO_DIR_PATH_INC . 'Lonyo-framework/plugins-activation/lonyo-active-plugins.php';


// page breadcrumbs
require_once LONYO_DIR_PATH_INC . 'lonyo-breadcrumbs.php';

// sidebar register
require_once LONYO_DIR_PATH_INC . 'lonyo-widgets-reg.php';

//essential functions
require_once LONYO_DIR_PATH_INC . 'lonyo-functions.php';

// theme dynamic css
require_once LONYO_DIR_PATH_INC . 'lonyo-commoncss.php';

// helper function
require_once LONYO_DIR_PATH_INC . 'wp-html-helper.php';

// pagination
require_once LONYO_DIR_PATH_INC . 'wp_bootstrap_pagination.php';

// hooks
require_once LONYO_DIR_PATH_HOOKS . 'hooks.php';

// hooks funtion
require_once LONYO_DIR_PATH_HOOKS . 'hooks-functions.php';


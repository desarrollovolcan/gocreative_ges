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

/**
 *
 * Define constant
 *
 */

// Base URI
if ( ! defined( 'LONYO_DIR_URI' ) ) {
    define('LONYO_DIR_URI', get_parent_theme_file_uri().'/' );
}

// Assist URI
if ( ! defined( 'LONYO_DIR_ASSIST_URI' ) ) {
    define( 'LONYO_DIR_ASSIST_URI', get_theme_file_uri('/assets/') );
}


// Css File URI
if ( ! defined( 'LONYO_DIR_CSS_URI' ) ) {
    define( 'LONYO_DIR_CSS_URI', get_theme_file_uri('/assets/css/') );
}

// Skin Css File
if ( ! defined( 'LONYO_DIR_SKIN_CSS_URI' ) ) {
    define( 'LONYO_DIR_SKIN_CSS_URI', get_theme_file_uri('/assets/css/skins/') );
}


// Js File URI
if (!defined('LONYO_DIR_JS_URI')) {
    define('LONYO_DIR_JS_URI', get_theme_file_uri('/assets/js/'));
}


// External PLugin File URI
if (!defined('LONYO_DIR_PLUGIN_URI')) {
    define('LONYO_DIR_PLUGIN_URI', get_theme_file_uri( '/assets/plugins/'));
}

// Base Directory
if (!defined('LONYO_DIR_PATH')) {
    define('LONYO_DIR_PATH', get_parent_theme_file_path() . '/');
}

//Inc Folder Directory
if (!defined('LONYO_DIR_PATH_INC')) {
    define('LONYO_DIR_PATH_INC', LONYO_DIR_PATH . 'inc/');
}

//LONYO framework Folder Directory
if (!defined('LONYO_DIR_PATH_FRAM')) {
    define('LONYO_DIR_PATH_FRAM', LONYO_DIR_PATH_INC . 'lonyo-framework/');
}

//Classes Folder Directory
if (!defined('LONYO_DIR_PATH_CLASSES')) {
    define('LONYO_DIR_PATH_CLASSES', LONYO_DIR_PATH_INC . 'classes/');
}

//Hooks Folder Directory
if (!defined('LONYO_DIR_PATH_HOOKS')) {
    define('LONYO_DIR_PATH_HOOKS', LONYO_DIR_PATH_INC . 'hooks/');
}

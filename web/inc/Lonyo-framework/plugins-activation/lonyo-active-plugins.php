<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme ecohost for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */



/**
 * Include the TGM_Plugin_Activation class.
 */
require_once LONYO_DIR_PATH_INC . 'Lonyo-framework/plugins-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'lonyo_register_required_plugins' );
function lonyo_register_required_plugins() {

    /*
    * Array of plugin arrays. Required keys are name and slug.
    * If the source is NOT from the .org repo, then source is also required.
    */

    $plugins = array(

        array(
            'name'                  => esc_html__( 'Lonyo Helper', 'lonyo' ),
            'slug'                  => 'lonyo-helper',
            'version'               => '1.0',
            'source'                => 'https://kit.framerpeak.com/plugins/lonyo/lonyo-helper.zip',
            'required'              => true,
        ),
        array(
            'name'                  => esc_html__( 'Mas Addons', 'lonyo' ),
            'slug'                  => 'mas-addons',
            'version'               => '1.0',
            'source'                => 'https://kit.framerpeak.com/plugins/lonyo/mas-addons.zip',
            'required'              => true,
        ),
        array(
            'name'                  => esc_html__( 'One Click Demo Importer', 'lonyo' ),
            'slug'                  => 'one-click-demo-import',
            'required'              => true,
        ),
        array(
            'name'      => esc_html__( 'Elementor', 'lonyo' ),
            'slug'      => 'elementor',
            'version'   => '',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__( 'MetForm', 'lonyo' ),
            'slug'      => 'metform',
            'version'   => '',
            'required'  => true,
        ),
        array(
            'name'      => esc_html__( 'WooCommerce', 'lonyo' ),
            'slug'      => 'woocommerce',
            'version'   => '',
            'required'  => true,
        ),

    );

    $config = array(
        'id'           => 'lonyo',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
    );

    tgmpa( $plugins, $config );
}
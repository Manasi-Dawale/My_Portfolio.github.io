<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detaihubfolio documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.2
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once  (get_template_directory()  . '/inc/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'hubfolio_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function hubfolio_theme_register_required_plugins() {

	global $framework_source_url, $elements_source_url;

	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from the WordPress Plugin Repository
		array(
			'name'      => esc_html__( 'Elementor Page Builder', 'hubfolio' ),
			'slug'      => 'elementor',
			'required'  => true,
		),
		array(
			'name'               => esc_html__( 'MetForm', 'hubfolio' ),
			'slug'               => 'metform',
			'required'           => true,
		), 
		array(
			'name'               => esc_html__( 'ThemesCamp Elements', 'hubfolio' ),
			'slug'               => 'themescamp-elements',
			'source'             => $elements_source_url,
			'required'           => true,
			'force_activation'   => false,// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name'               => esc_html__( 'ThemesCamp Core', 'hubfolio' ),
			'slug'               => 'themescamp-core',
			'source' 			 => $framework_source_url, 
			'required'           => true,
			'force_activation'   => false,// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
	);

    // Apply the filter to allow modification of the plugins list
    $plugins = apply_filters( 'tcg_required_plugins', $plugins );

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundhubfolio plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'admin.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.	
	);

	tgmpa( $plugins, $config );
}

if ( ! function_exists( 'tcg_deactivate_ocdi' ) ) {
	function tcg_deactivate_ocdi() {
		// Path to the plugin file
		$plugin_file = WP_PLUGIN_DIR . '/one-click-demo-import/one-click-demo-import.php';

		// Check if the plugin file exists
		if ( file_exists( $plugin_file ) ) {
			// Deactivate the plugin
			deactivate_plugins( 'one-click-demo-import/one-click-demo-import.php' );
		}
	}
}
add_action( 'admin_init', 'tcg_deactivate_ocdi' );

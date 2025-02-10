<?php

// version 1.1.0 - FS_METHOD check in theme.json

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Xinterio_Theme_Manager {

	/**
	 * Holds the current instance of the theme manager
	 *
	 * @var Xinterio_Theme_Manager
	 */
	private static $instance = null;

	/**
	 * @return Xinterio_Theme_Manager
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 *
	 * Theme settings from the theme.json file.
	 *
	 * @var array
	 */
	public $theme_settings = array();

	/*
	 * This is the magic that sets up all the hooks and filters for the theme.
	 */
	/**
	 *
	 */
	public function start() {
		$this->include_theme_files();
	}

	public function init() {
		$this->get_theme_settings();
	}
	

	public function get_theme_setting( $key, $default = false ) {
	    if(!$this->theme_settings){
	        $this->get_theme_settings();
        }
		if ( isset( $this->theme_settings[ $key ] ) ) {
			return $this->theme_settings[ $key ];
		}

		return $default;
	}

	public function get_theme_settings() {
		if ( $this->theme_settings ) {
			return $this->theme_settings;
		}
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		WP_Filesystem();
		global $wp_filesystem;
		$this->theme_settings = json_decode( $wp_filesystem->get_contents( trailingslashit( XINTERIO_TSW_PATH ) . 'theme.json' ), true );
		if ( ! is_array( $this->theme_settings ) ) {
			$this->theme_settings = array();
		}
		// todo - check FS_METHOD is set to 'direct' if we get no theme_settings back.
        if(empty($this->theme_settings)){
	        add_action('admin_notices', function() {
	            ?> <div class="notice notice-error is-dismissible">
					<p><?php sprintf( 'Unable to read %1$s settings file. Please try to add %2$s to your %3$s file. Contact support or your hosing provider for assistance.',
						pbmit_esc_kses('<code>theme.json</code>'),
						pbmit_esc_kses('<code>define("FS_METHOD","direct");</code>'),
						pbmit_esc_kses('<code>wp-config.php</code>')
						); ?></p>
                </div>
                <?php
            } );
        }

		return $this->theme_settings;
	}
	
	public function include_theme_files() {
		/*
		$theme_files = array();

		$theme_files[] = 'envato_setup/envato_setup.php';
		$theme_files[] = 'includes/class-tgm-plugin-activation.php';

		foreach ( apply_filters( 'xinterio_theme_files', $theme_files ) as $theme_file ) {
			$template_file = locate_template( $theme_file );
			if ( $template_file && is_readable( $template_file ) ) {
				require_once $template_file;
			}
		}
		*/

		include_once( XINTERIO_TSW_PATH . 'envato_setup/envato_setup.php' );
		if( file_exists( get_template_directory() . '/includes/class-tgm-plugin-activation.php' ) ){
			include_once( get_template_directory() . '/includes/class-tgm-plugin-activation.php' );
		}

	}

	public $default_color = 'style1';

}


<?php
/*
Plugin Name: Xinterio Theme Setup Wizard
Plugin URI: https://pbminfotech.com/
Description: Theme Setup Wizard for Xinterio Theme
Version: 3.0
Author: PBM Infotech Team
Author URI: https://pbminfotech.com/
Text Domain: xinterio-tsw
Domain Path: /language
*/

// security
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'XINTERIO_TSW_VERSION', '3.0' );
define( 'XINTERIO_TSW_PATH', plugin_dir_path( __FILE__ ) ); // with trailing slash
define( 'XINTERIO_TSW_URL',  plugin_dir_url( __FILE__ )  ); // with trailing slash



if( ! function_exists('xinterio_tsw_activate_flag') ){
function xinterio_tsw_activate_flag(){
	if( get_option( 'xinterio_tsw_activated_once' ) != 'yes' ){
		update_option('xinterio_tsw_activated_once', 'yes');
	}
}
}
add_action( 'admin_init', 'xinterio_tsw_activate_flag' );


if( ! function_exists('xinterio_tsw_scripts_styles') ){
function xinterio_tsw_scripts_styles(){
	wp_enqueue_style( 'xinterio-tsw-style', XINTERIO_TSW_URL . 'css/style.css' );
}
}
add_action( 'admin_enqueue_scripts', 'xinterio_tsw_scripts_styles' );


/* *** Envato Theme Setup Wizard settings **** */

//require_once XINTERIO_TSW_PATH . 'envato_setup/envato_setup_init.php';
// Please don't forgot to change filters tag.
// It must start from your theme's name.
add_filter('xinterio_theme_setup_wizard_username', 'xinterio_set_theme_setup_wizard_username', 10);
if( ! function_exists('xinterio_set_theme_setup_wizard_username') ){
    function xinterio_set_theme_setup_wizard_username($pbminfotech){
        return 'pbminfotech';
    }
}

add_filter('xinterio_theme_setup_wizard_oauth_script', 'xinterio_set_theme_setup_wizard_oauth_script', 10);
if( ! function_exists('xinterio_set_theme_setup_wizard_oauth_script') ){
    function xinterio_set_theme_setup_wizard_oauth_script($oauth_url){
        return 'https://pbminfotech.com/envato-api/themestek/';
    }
}

if ( ! defined( 'xinterio_theme_version' ) ) {
	define( 'xinterio_theme_version', '1.0' );
}

if ( ! class_exists( 'Xinterio_Theme_Manager', false ) ) {
	// includes core theme manager class and default settings.
	require_once( XINTERIO_TSW_PATH . 'theme_setup_class.php' );
}


if ( class_exists( 'Xinterio_Theme_Manager', false ) ) {
	

	class Xinterio_Theme_Manager_Custom extends Xinterio_Theme_Manager {

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

		public function start(){

			add_filter('xinterio_default_headers', array($this,'default_headers'));
			add_filter('xinterio_custom_header_args', array($this,'xinterio_custom_header_args'));
			add_filter('xinterio_featured_image_options', array($this,'xinterio_featured_image_options'));
			add_filter('xinterio_page_options', array($this,'xinterio_page_options'));
            add_filter('elementor/widget/render_content', array($this,'elementor_render_content'), 10, 2);

			parent::start();
		}

        public function elementor_render_content( $html, $widget ){
            $settings = $widget->get_settings();
            // this config option is set from theme.json and controlled through the elementor UI
            if(!empty($settings['slider_labels']) && $settings['slider_labels'] == 'labels'){
                // inject our labels into the HTML
                if( preg_match_all('#<figure class="slick-slide-inner">.*alt="([^"]*)".*</figure>#imsU', $html, $matches) ){
                    foreach($matches[0] as $key => $attachment){

                        $image_caption = $matches[1][$key];

                        $image_id = !empty($settings['carousel'][$key]['id']) ? $settings['carousel'][$key]['id'] : false;
                        if($image_id){
                            $image_data = get_post( $image_id );
                            if($image_data) {
                                $image_caption = $image_data->post_excerpt;
                                $image_description = $image_data->post_content;
                            }
                        }
                        $html = str_replace( $attachment, str_replace('<figure class="slick-slide-inner">', '<figure class="slick-slide-inner"><div class="xinterio-slider-caption"><div class="inner-content-width"><div><h3>' . esc_html( $image_caption ) . '</h3><div>' . esc_html( $image_description ) . '</div></div></div></div>', $attachment), $html );
                    }
                }
            }
            return $html;
        }

		public function setup_background() {

			// Set up the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'xinterio_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
			) ) );
		}

		public function xinterio_page_options($page_options){
			$page_options['title']['options']['show'] = 'Fancy Title';
			$page_options['title']['options']['normal'] = 'Normal Title';

			$page_options['background'] = array(
				'title'   => 'Page Background',
				'options' => array(
					'transparent' => 'Transparent',
					'normal' => 'Bordered',
				),
				'default' => 'transparent',
			);

			return $page_options;
		}

		public function setup_images() {
			parent::setup_images();
			add_image_size( 'xinterio_gallery_square', 600, 600, true );
			add_image_size( 'xinterio_wide_slider', 1500, 385, true );
			add_image_size( 'xinterio_blog-large', 1500, 9999, false );
			set_post_thumbnail_size( 800, 410, true );
		}

		public function excerpt_length() {
			return 70;
		}

		public function xinterio_featured_image_options($images){
			return array();
		}
		public function xinterio_custom_header_args($headerargs){
		    $headerargs['default-image'] = XINTERIO_TSW_URL . '/images/header2-top-lg.png';
		    return $headerargs;
        }
		public function default_headers($headers){
			$headers['header1'] = array(
				'url'           => '%s/images/header1-bottom-lg.png',
				'thumbnail_url'           => '%s/images/header1-bottom-lg.png',
				'description'   => esc_html__( 'Header', 'xinterio-tsw' )
			);
			$headers['header2'] = array(
				'url'           => '%s/images/header2-top-lg.png',
				'thumbnail_url'           => '%s/images/header2-top-lg.png',
				'description'   => esc_html__( 'Header', 'xinterio-tsw' )
			);
			$headers['header3'] = array(
				'url'           => '%s/images/header3-top-sml.png',
				'thumbnail_url'           => '%s/images/header3-top-sml.png',
				'description'   => esc_html__( 'Header', 'xinterio-tsw' )
			);
			return $headers;
		}

		public function after_setup_theme(){

			parent::after_setup_theme();
		}

		public function xinterio_blog_date(){
			if(get_post_type() == 'post') {
				?>
                <div class="blog_date">
                    <span class="day"><?php echo get_the_date( 'j' ); ?></span>
                    <span class="month"><?php echo get_the_date( 'M' ); ?></span>
                    <span class="year"><?php echo get_the_date( 'Y' ); ?></span>
                </div>
				<?php
			}
		}

	}

	require_once XINTERIO_TSW_PATH.'envato_setup/envato_setup_init.php';

	Xinterio_Theme_Manager_Custom::get_instance()->start();
}






/**
 *  Merlin Message
 */
if( !function_exists('pbmit_merlin_message') ){
function pbmit_merlin_message() {
	?>
	<div class="pbmit-tsw-message-box notice is-dismissible">
		<div class="pbmit-tsw-message">


			<div class="pbmit-tsw-message-conform">
				<div class="pbmit-tsw-message-conform-inner">
					<div class="pbmit-tsw-message-conform-i">
						<div class="pbmit-tsw-message-conform-col pbmit-tsw-message-conform-img">
							<img src="<?php echo XINTERIO_TSW_URL; ?>images/merlin-message.png" />
						</div>
						<div class="pbmit-tsw-message-conform-col pbmit-tsw-message-conform-text">
							<h3><?php esc_html_e('Are you sure you want to permenently close this wizard?', 'xinterio-tsw'); ?></h3>
							<p><?php printf( esc_html__('You can start this wizard from %1$s Appearance > Xinterio Theme Setup %2$s section', 'xinterio-tsw') ,pbmit_esc_kses('<strong>') ,pbmit_esc_kses('</strong>') );  ?></p>
							<div class="pbmit-tsw-message-conform-btn">
								<a href="#" class="button button-primary pbmit-disable-merlin-message"><?php esc_html_e('Yes close this message', 'xinterio-tsw'); ?></a>
								&nbsp; &nbsp;
								<a href="#" class="button pbmit-disable-merlin-message-cancel"><?php esc_html_e('No, keep this message', 'xinterio-tsw'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- .pbmit-tsw-message-conform -->
			<div class="pbmit-tsw-message-inner">


				<div class="pbmit-tsw-message-logo-main">
					<div class="pbmit-tsw-message-logo">
						<img src="<?php echo XINTERIO_TSW_URL; ?>images/logo.png" />
					</div>
					<!-- <div class="pbmit-tsw-message-vline">
						<div class="pbmit-tsw-message-vline-i"></div>
					</div> -->
					<div class="pbmit-tsw-message-text">

						<div class="pbmit-content-box">
							<h2><?php esc_html_e('Xinterio Theme Setup Wizard', 'xinterio-tsw'); ?></h2>
							<p><?php printf( esc_html__('This Xinterio theme comes with one-click setup wizard. This step-by-step wizard will %1$sinstall all required plugins, install demo content (you can skip this), import sliders, set logo, set global color%2$s and also %1$ssome basic information%2$s.', 'xinterio-tsw'), '<strong>', '</strong>' ); ?></p>
						</div>

						<div class="pbmit-tsw-message-btn">
							<div class="pbmit-tsw-message-btn-i">
								<a href="<?php echo admin_url( 'themes.php?page=xinterio-setup' ); ?>" class="pbmit-setwizard load-customize hide-if-no-customize"><?php esc_html_e('Start Theme Setup Wizard', 'xinterio-tsw'); ?></a>
							</div>
						</div>

					</div>
				</div>

				<div class="clear clearfix clr"></div>
			</div><!-- .pbmit-tsw-message-inner -->

		</div><!-- .pbmit-tsw-message -->
	</div><!-- .notice.is-dismissible -->
	<?php
}
}

if( !function_exists('xinterio_tsw_check_if_xinterio_theme') ){
function xinterio_tsw_check_if_xinterio_theme(){
	$return = false;
	if( is_child_theme() ){
		$active_theme = wp_get_theme( get_template() );
	} else {
		$active_theme = wp_get_theme();
	}
	$current_theme = trim( $active_theme->get( 'TextDomain' ) );
	if( !empty( $current_theme ) && $current_theme == 'xinterio' ){
		$return = true;
	}
	return $return;
}
}


if( !function_exists('pbmit_merlin_fresh_setup_call') ){
function pbmit_merlin_fresh_setup_call(){

	$theme = xinterio_tsw_check_if_xinterio_theme();

	if( $theme !== true ){
		add_action( 'admin_notices', 'pbmit_enable_xinterio_theme' );
	} else {
		$pbmit_merlin_all_done = get_option('xinterio_tsw_all_done');
		if( empty($pbmit_merlin_all_done) ){
			add_action( 'admin_notices', 'pbmit_merlin_message' );
		}
	}


}
}
add_action( 'init', 'pbmit_merlin_fresh_setup_call' );





if( !function_exists('pbmit_enable_xinterio_theme') ){
function pbmit_enable_xinterio_theme() {
	?>
	<div class="xinterio-tsw-message-box notice is-dismissible">
		<div class="xinterio-tsw-message">
			<img class="warning-sign-image" src="<?php echo XINTERIO_TSW_URL; ?>images/warning-sign.png">
			<h2><?php esc_attr_e( 'This is not the Xinterio theme. Please enable Xinterio theme to enable Theme Setup Wizard', 'xinterio-tsw' ) ?></h2>
			<p><?php esc_attr_e( 'You enabled the "Xinterio Theme Setup Wizard" plugin. But the current theme is not Xinterio theme so the setup wizard will not continue. Please enable "Xinterio" theme or disable this "Xinterio Theme Setup Wizard" plugin.', 'xinterio-tsw' ) ?></p>
			<div class="clear clr clearfix"></div>
		</div><!-- .xinterio-tsw-message -->
	</div><!-- .notice.is-dismissible -->
	<?php
}
}








if( !function_exists('pbmit_esc_kses') ) {
function pbmit_esc_kses( $html = '' ) {
	$return = '';
	$allowed_html = array(
		'p'	=> array(
			'class'		=> array(),
			'id'		=> array(),
		),
		'noscript'	=> array(),
		'a'			=> array(
			'class'			=> array(),
			'href'			=> array(),
			'title'			=> array(),
			'target'		=> array(),
			'rel'			=> array(),
			'data-sortby'	=> array(),
		),
		'button'	=> array(
			'class'		=> array(),
			'href'		=> array(),
			'title'		=> array(),
		),
		'ul'		=> array(
			'class'		=> array(),
		),
		'ol'		=> array(
			'class'		=> array(),
		),
		'li'		=> array(
			'class'			=> array(),
			'data-content'	=> array(),
		),
		'br'		=> array(),
		'em'		=> array(),
		'strong'	=> array(),
		'i'			=> array(
			'class'		=> array(),
			'style'		=> array(),
		),
		'small'	=> array(
			'name'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'div'		=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'role'			=> array(),
			'data-bg'		=> array(),
			'data-iconset'	=> array(),
			'data-icon'		=> array(),
			'data-appear-animation'	=> array(),
			'data-from'			=> array(),
			'data-to'			=> array(),
			'data-interval'		=> array(),
			'data-before'		=> array(),
			'data-before-style'	=> array(),
			'data-after'		=> array(),
			'data-after-style'	=> array(),
			'data-digit'		=> array(),
			'data-fill'			=> array(),
			'data-size'			=> array(),
			'data-emptyfill'	=> array(),
			'data-thickness'	=> array(),
			'data-filltype'		=> array(),
			'data-gradient1'	=> array(),
			'data-gradient2'	=> array(),
			'data-max'			=> array(),
			'data-tag'			=> array(),
			'data-id'			=> array(),
			'data-model-id'		=> array(),
			'data-shortcode-controls'		=> array(),
			'data-x-start'		=> array(),
			'data-x-end'  		=> array(),
			'data-y-start'		=> array(),
			'data-y-end'  		=> array(),
			'data-scale-x-start'=> array(),
			'data-scale-x-end'  => array(),
			'data-scale-y-start'=> array(),
			'data-scale-y-end'  => array(),
			'data-skew-x-start'=> array(),
			'data-skew-x-end'  => array(),
			'data-skew-y-start'=> array(),
			'data-skew-y-end'  => array(),
			'data-rotate-x-start'=> array(),
			'data-rotate-x-end'  => array(),
			'data-rotate-y-start'=> array(),
			'data-rotate-y-end'  => array(),
			'data-frame-count'	 => array(),
			'data-height' 		 => array(),
			'data-width' 		 => array(),
			'data-cursor-text'   => array(),
			'data-magnetic'      => array(),
			'data-cursor'        => array(),
			'data-cursor-stick'  => array(),
			'data-cursor-tooltip'=> array(),
		),
		'span'		=> array(
			'class'				=> array(),
			'id'				=> array(),
			'style'				=> array(),
			'data-appear-animation'	=> array(),
			'data-from'			=> array(),
			'data-to'			=> array(),
			'data-interval'		=> array(),
			'data-before'		=> array(),
			'data-before-style'	=> array(),
			'data-after'		=> array(),
			'data-after-style'	=> array(),
			'data-digit'		=> array(),
			'data-fill'			=> array(),
			'data-size'			=> array(),
			'data-emptyfill'	=> array(),
			'data-thickness'	=> array(),
			'data-filltype'		=> array(),
			'data-gradient1'	=> array(),
			'data-gradient2'	=> array(),
			'data-percentage-value'	=> array(),
			'data-value'		=> array(),
		),
		'h1'			=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
		),
		'h2'			=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'data-text'	=> array(),
		),
		'h3'			=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'data-text'	=> array(),
		),
		'h4'			=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'data-text'	=> array(),
		),
		'h5'			=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'data-text'	=> array(),
		),
		'h6'			=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
		),
		'header'	=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
		),
		'img'		=> array(
			'class'		=> array(),
			'src'		=> array(),
			'alt'		=> array(),
			'title'		=> array(),
			'width'		=> array(),
			'height'	=> array(),
			'srcset'	=> array(),
			'sizes'		=> array(),
			'data-id'	=> array(),
			'data-srcset' => array(),
			'data-src'	=> array(),
		),
		'time'	=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'datetime'	=> array(),
		),
		'iframe'	=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'width'		=> array(),
			'height'	=> array(),
			'src'		=> array(),
			'frameborder'	=> array(),
			'allow'		=> array(),
			'allowfullscreen'	=> array(),
		),
		'blockquote'	=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'article'	=> array(
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'input'	=> array(
			'type'			=> array(),
			'name'			=> array(),
			'value'			=> array(),
			'placeholder'	=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'checked'		=> array(),
		),
		'textarea'	=> array(
			'name'			=> array(),
			'value'			=> array(),
			'placeholder'	=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'form'	=> array(
			'name'			=> array(),
			'method'		=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
			'data-id'		=> array(),
			'data-name'		=> array(),
		),
		'label'	=> array(
			'for'			=> array(),
			'name'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'aside'	=> array(
			'name'			=> array(),
			'class'			=> array(),
			'id'			=> array(),
			'style'			=> array(),
		),
		'sup'	=> array(
			'class'			=> array(),
		),
		'sub'	=> array(
			'class'			=> array(),
		),
		'pre'	=> array(),
		'table'	=> array(
			'class'			=> array(),
			'style'			=> array(),
			'data-ninja_table_instance'	=> array(),
			'data-footable_id'	=> array(),
			'data-filter-delay'	=> array(),
			'aria-label'	=> array(),
			'id'			=> array(),
			'data-unique_identifier'	=> array(),
		),
		'thead'	=> array(
			'class'			=> array(),
		),
		'tr'	=> array(
			'class'			=> array(),
		),
		'th'	=> array(
			'class'			=> array(),
			'colspan'		=> array(),
			'scope'			=> array(),
		),
		'colgroup'	=> array(
			'class'			=> array(),
		),
		'tfoot'	=> array(
			'class'			=> array(),
		),
		'tspan'	=> array(
			'class'			=> array(),
		),
		'tbody'	=> array(
			'class'			=> array(),
		),
		'lottie-player'	=> array(
			'class'		=> array(),
			'id'		=> array(),
			'style'		=> array(),
			'width'		=> array(),
			'height'	=> array(),
			'src'		=> array(),
			'mode'		=> array(),
			'loop'		=> array(),
			'controls'	=> array(),
			'autoplay'	=> array(),
			'speed'	    => array(),
			'background' => array(),
		),
		'script'	=> array(
			'class'			=> array(),
		),
		'line'	=> array(
			'x1'			=> array(),
			'y1'			=> array(),
			'x2'			=> array(),
			'y2'			=> array(),
		),
		'svg'	=> array(
			'class'			=> array(),
			'id'			=> array(),
			'xmlns'			=> array(),
			'xmlns:xlink'	=> array(),
			'x'				=> array(),
			'y'				=> array(),
			'viewbox'		=> array(),
			'style'			=> array(),
			'xml:space'		=> array(),
			'width'			=> array(),
			'height'		=> array(),
			'fill-rule'		=> array(),
			'clip-rule'		=> array(),
		),
		'g'		=> array(			
			'stroke-miterlimit'	  => array(),
			'stroke-linejoin'	  => array(),
			'stroke'		      => array(),
			'stroke-width'		  => array(),	
			'fill'		          => array(),	
		),
		'circle'		=> array(
			'cy'		=> array(),
			'cx'		=> array(),
			'r'			=> array(),	
			'class'		=> array(),	
		),
		'defs'	=> array(
			'class'		=> array(),
			'id'	    => array(),
		),
		'path'	=> array(
			'd'			=> array(),
			'stroke'	=> array(),
			'id' 	    => array(),
		),
		'text'	=> array(
			'class'		=> array(),
			'id'	    => array(),
		),
		'textPath'	 => array(
			'startOffset'   => array(),
			'xmlns:xlink'	=> array(),
		),
	);
	if( !empty($html) ){
		$return = wp_kses($html, $allowed_html);
	}
	return $return;
}
}



function pbmit_tsw_activation_redirect( $plugin ) {
	if( isset($_GET['page']) && $_GET['page'] == 'tgmpa-install-plugins' ){
		?>
		<div id="pbmit-redirecting-message" class="updated"><p><?php esc_html_e( 'Redirecting to Theme Setup Wizard.. Please wait !!!', 'xinterio-tsw' ); ?></p></div>
		<?php
	} else {
		if( $plugin == plugin_basename( __FILE__ ) ) {
			exit( wp_redirect( admin_url( 'themes.php?page=xinterio-setup' ) ) );
		}
	}
}
add_action( 'activated_plugin', 'pbmit_tsw_activation_redirect', 1 );

// Woocommerce plugin setup wizard redirection off
add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );
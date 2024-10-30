<?php
/*
 * Plugin Name: isMobile() Shortcode for WordPress
 * Plugin URI: https://www.dixitalmedia.com/#que-hacemos
 * Description: Simple plugin that shows or hides the content depending on the device, its brand or OS through the use of a shortcode. <u>Works with <a title="Mobile Detect Library" target="_blank" href="http://mobiledetect.net" >Mobile Detect Library</a></u>.  
 * Version: 1.1.1
 * Author: jairoochoa
 * Author URI: https://www.dixitalmedia.com/
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ismobile
 * Domain Path: /languages/
 */	


if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}



/* Load Mobile Detect library
============================================================================= */

if ( !class_exists( 'Mobile_Detect' ) || !class_exists( 'MobileDetect' ) ) {
	require_once 'libs/Mobile_Detect.php';
}

$wis_detect = new Mobile_Detect;




/* Load plugin textdomain
============================================================================= */

function wis_load_textdomain() {
	load_plugin_textdomain( 'ismobile', false, dirname(plugin_basename(__FILE__)).'/languages/' ); 
}

add_action( 'plugins_loaded', 'wis_load_textdomain' );





/* Shortcode
============================================================================= */


function wis_ismobile( $wis_params, $wis_content = null ) {

	global $wis_detect;
	
	$wis_param = shortcode_atts( array (
		'device' => 'mobile', 
		'debug'  => false,
		'shortcode'  => false, // not in use right now
	), $wis_params );
	
	$wis_search = explode ( ',', strtolower( $wis_param['device'] ) );
	$wis_debug  = ( strtolower ( $wis_param['debug'] ) === 'true' ) ? true : false;
	$shortcode  = ( strtolower ( $wis_param['shortcode'] ) === 'true' ) ? true : false; // not in use right now

	$wis_device = array();

	$wis_device[] = ( $wis_detect->isMobile() ) ? 'mobile' : 'desktop';
	if ( $wis_detect->isTablet() ) $wis_device[] = 'tablet';
	if ( $wis_detect->isMobile() && !$wis_detect->isTablet() ) $wis_device[] = 'phone';
	if ( $wis_detect->isIphone() ) $wis_device[] = 'iphone';
	if ( $wis_detect->isSamsung() ) $wis_device[] = 'samsung';
	if ( $wis_detect->isiPad() ) $wis_device[] = 'ipad';
	if ( $wis_detect->isiOS() ) $wis_device[] = 'ios';
	if ( $wis_detect->isAndroidOS() ) $wis_device[] = 'android';
	if ( $wis_detect->isSafari() ) $wis_device[] = 'safari';
	if ( $wis_detect->isChrome() ) $wis_device[] = 'chrome';
	
	$wis_success = !empty ( array_intersect ( $wis_search, $wis_device ) );

	if ( $wis_debug ) : 
		
		// if debug mode it's only shown the device data and the searched device. Content is not shown.
		$wis_debug_output = '';
		$wis_debug_output .= '<pre style="font-family: monospace; margin: 50px 0 20px 0; color: red; ">';
		$wis_debug_output .= 'Mobile Detect Library ' . $wis_detect->getScriptVersion();  $wis_debug_output .= '<br /><br />';
		$wis_debug_output .= '$wis_device = '; ob_start(); var_dump($wis_device); $wis_debug_output .= ob_get_clean(); $wis_debug_output .= '<br />';
		$wis_debug_output .= '$wis_search = '; ob_start(); var_dump($wis_search); $wis_debug_output .= ob_get_clean(); $wis_debug_output .= '<br />';
		if ( $wis_success ) $wis_debug_output .= __( 'Matches !', 'ismobile' ) . '<br />';
		$wis_debug_output .= '</pre>';
		
		return $wis_debug_output;
	
	else :
	
		if ( $wis_success ) : 
			//if ( $shortcode ) return apply_filters('the_content', $wis_content); else return $wis_content;
			return apply_filters('the_content', $wis_content);
		else : 
			return;
		endif;

	endif;

}

add_shortcode( 'ismobile', 'wis_ismobile' );




/* Help page
============================================================================= */


function wis_add_action_links( $wis_links ) {

	$wis_links[] = '<a href="' . esc_url( get_admin_url( null, 'plugins.php?page=ismobile_help' ) ) . '">'. __( 'Help', 'ismobile' ) . '</a>';
	return $wis_links;

}

add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'wis_add_action_links' );



function wis_add_ismobile_page() {
	add_submenu_page(
		'plugins.php',
		__( 'isMobile() Shortcode for WordPress', 'ismobile' ),
		__( 'isMobile()', 'ismobile' ),
		'manage_options',
		'ismobile_help',
		'wis_add_ismobile_page_contents'
	);
}

add_action( 'admin_menu', 'wis_add_ismobile_page' );



function wis_add_ismobile_page_contents() {
?>

<div id="ismobile" class="wrap">
	
	<h1 class="ismobile-heading"><?php echo get_admin_page_title() ?></h1>
	
	<div class="ismobile-sub">
		<div class="alignleft">
			<p><?php _e( 'This plugin works with the open source <a title="Mobile Detect Library" target="_blank" href="http://mobiledetect.net" >Mobile Detect Library</a>. You can get further information on its website.', 'ismobile' ) ?></p>
			<p><a href="http://mobiledetect.net" target="_blank"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>/img/mobiledetect-logo.png" width="450px" alt="Mobile Detect" title="Mobile Detect"></a></p>
		</div>
		<br class="clear">
	</div>

	<div class="clear"></div>

	<p class="shortcode">[ismobile <b>device</b>='iphone' <b>debug</b>=false ] <?php _e( 'Your content', 'ismobile' ); ?> [/ismobile]</p>

	<div class="card">
		<h2 class="title"><?php _e( 'Parameters', 'ismobile' ) ?></h2>
		<dl>
			<dt><b>device</b>:</dt>
			<dd><?php _e( 'Filters the device where you want the content to be shown. <br />It could be more than one device, simply separate them with comma.', 'ismobile' ) ?></dd>
			<dt><b>debug</b>:</dt>
			<dd><?php _e( 'Shows Mobile Detect Library installed version. <br />Also shows two arrays. The first one contains the devices which the library detects and the second one contains the devices where you want to show the content.', 'ismobile' ) ?></dd>
		</dl>
	</div>

	<div class="clear"></div>

	<div class="card">
		<h2 class="title"><?php _e( 'Values', 'ismobile' ) ?></h2>
		<dl>
			<dt><b>android</b>:</dt>
			<dd><?php _e( 'Shows content in Android devices.', 'ismobile' ) ?></dd>
			<dt><b>chrome</b>:</dt>
			<dd><?php _e( 'Shows content on Chrome browser (Only works on mobile devices).', 'ismobile' ) ?></dd>
			<dt><b>desktop</b>:</dt>
			<dd><?php _e( 'Shows content on a computer. Opposite to <u>mobile</u> option.', 'ismobile' ) ?></dd>
			<dt><b>ios</b>:</dt>
			<dd><?php _e( 'Shows content in iOS devices.', 'ismobile' ) ?></dd>
			<dt><b>ipad</b>:</dt>
			<dd><?php _e( 'Shows content on a iPad.', 'ismobile' ) ?></dd>
			<dt><b>iphone</b>:</dt>
			<dd><?php _e( 'Shows content on a iPhone.', 'ismobile' ) ?></dd>
			<dt><b>mobile</b>:</dt>
			<dd><?php _e( 'Shows content on a mobile device (includes tablets and cell phones). Opposite to <u>desktop</u> option.', 'ismobile' ) ?></dd>
			<dt><b>phone</b>:</dt>
			<dd><?php _e( 'Shows content on a cell phone.', 'ismobile' ) ?></dd>
			<dt><b>safari</b>:</dt>
			<dd><?php _e( 'Shows content on Safari browser (Only works on mobile devices).', 'ismobile' ) ?></dd>
			<dt><b>samsung</b>:</dt>
			<dd><?php _e( 'Shows content on Samsung devices.', 'ismobile' ) ?></dd>
			<dt><b>tablet</b>:</dt>
			<dd><?php _e( 'Shows content on a tablet.', 'ismobile' ) ?></dd>
		</dl>
	</div>	
	
	<div class="clear"></div>

	<div class="card">
		<h2 class="title"><?php _e( 'Examples', 'ismobile' ) ?></h2>
		
		<ul>
			<li>
				<h3 class="subtitle"><?php _e( 'Show the content on cell phones', 'ismobile' ) ?></h3>
				<p>[ismobile device='phone'] <?php _e( 'I\'m a cell phone', 'ismobile' ); ?> [/ismobile]</p>
			</li>
			<li>
				<h3 class="subtitle"><?php _e( 'Show the content on computers and tablets', 'ismobile' ) ?></strong></h3>
				<p>[ismobile device='tablet,desktop'] <?php _e( 'I\'m a tablet or maybe I\'m a computer', 'ismobile' ); ?> [/ismobile]</p>
			</li>
			<li>
				<h3 class="subtitle"><?php _e( 'Show the content on a iPad', 'ismobile' ) ?></strong></h3>
				<p>[ismobile device='ipad'] <?php _e( 'I\'m a iPad', 'ismobile' ); ?> [/ismobile]</p>
			</li>

			<li>
				<h3 class="subtitle"><?php _e( 'Show content in Android devices', 'ismobile' ) ?></strong></h3>
				<p>[ismobile device='android'] I love Android [/ismobile]</p>
			</li>
		</ul>

	</div>

	<div class="clear"></div>

	<div class="card">
		<h2 class="title"><?php _e( 'FAQ', 'ismobile' ) ?></h2>
		
		<ul>
			<li>
				<h3 class="subtitle"><?php _e( 'Does <i>isMobile() Shortcode for WordPress</i> support shortcodes?', 'ismobile' ) ?></strong></h3>
				<p><?php _e( 'Yes, content could be a plain text or even a shortcode.', 'ismobile' ) ?><br />
				[ismobile device='desktop'] [youtube https://youtu.be/Wc6hMTasjtU] [/ismobile]</p>
			</li>
			<li>
				<h3 class="subtitle"><?php _e( 'What is Debug Mode?', 'ismobile' ) ?></strong></h3>
				<p><?php _e( 'If <i>isMobile() Shortcode for WordPress</i> doesn\'t work as expected you can enter Debug Mode in order to check what do the plugin detects and you have input. Notice that content is not shown.', 'ismobile' ) ?><br />
				[ismobile device='ipad' debug=true] <?php _e( 'Your content', 'ismobile' ); ?> [/ismobile]</p>
			</li>
		</ul>

	</div>

	<div class="clear"></div>

</div>

<div class="clear"></div>

<?php
}



function wis_ismobile_admin_enqueue_scripts() {

	if ( isset ( $_GET['page'] ) && $_GET['page'] == 'ismobile_help' ) :
		wp_register_style( 'ismobile-css', plugin_dir_url( __FILE__ ) . 'css/ismobile.css', false, '1.0', 'all' );
		wp_enqueue_style( 'ismobile-css' );
	endif;
}

add_action( 'admin_enqueue_scripts', 'wis_ismobile_admin_enqueue_scripts' );










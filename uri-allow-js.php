<?php
/**
 * Plugin Name: URI Allow Javascript
 * Plugin URI: https://www.uri.edu/wordpress
 * Description: Provides a mechanism to let certain users post javascript
 * Version: 1.0
 * Author: URI Web Communications
 * Author URI: https://www.uri.edu/wordpress
 *
 * @author: Brandon Fuller <bjcfuller@uri.edu>
 * @author: John Pennypacker <jpennypacker@uri.edu>
 */

// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

define( 'URI_JS_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'URI_JS_URL', plugin_dir_url( __FILE__ ) );

// Include display posts extensions
include( URI_JS_DIR_PATH . 'inc/profile.php' );


/**
 * Enable unfiltered_html capability for selected users.
 * @param arr $caps the user's capabilities.
 * @param str $cap capability name.
 * @param int $user_id the user ID.
 * @return arr $caps updated capabilities
 */
function uri_allow_js_unfiltered_html( $caps, $cap, $user_id ) {

	$js_ok = get_the_author_meta( 'uri_allow_js_trusted', $user_id );

	if ( 'unfiltered_html' === $cap && 'true' === $js_ok ) {
		$caps = array( 'unfiltered_html' );
	}
	return $caps;

}
add_filter( 'map_meta_cap', 'uri_allow_js_unfiltered_html', 1, 3 );


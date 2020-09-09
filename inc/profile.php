<?php

// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


/**
 * Displays the allow js checkbox on the user profile.
 * @param obj $user the user object.
 */
function uri_allow_js_show_checkbox( $user ) {

	if ( !_uri_user_can_update() ) { 
		return false; 
	}

	$checked = esc_attr( get_the_author_meta( 'uri_allow_js_trusted', $user->ID ) );
// 	echo '<pre>';
// 	var_dump($checked);
// 	echo '</pre>';
	?>
	<h3><?php _e('Allow Javascript / Unfiltered HTML', 'uri'); ?></h3>

	<table class="form-table">
	<tr>
		<th><label for="uri_allow_js_trusted"><?php _e('Trust this user?'); ?></label></th>
		<td>
			<input type="checkbox" name="uri_allow_js_trusted" id="allow-js" value="true" <?php echo ("true" === $checked) ? 'checked' : ''; ?> /><br />
			<span class="description"><?php _e('Allows this user to post unfiltered HTML and javascript. Use thoughfully.'); ?></span>
		</td>
	</tr>
	</table>
	<?php
}
add_action( 'show_user_profile', 'uri_allow_js_show_checkbox' );
add_action( 'edit_user_profile', 'uri_allow_js_show_checkbox' );


/**
 * Saves the value from the checkbox displayed in the user's profile.
 * @param int $user_id the user's id.
 */
function uri_allow_js_save_profile_fields( $user_id ) {
	if ( !_uri_user_can_update() ) { 
		return false; 
	}
	update_user_meta( $user_id, 'uri_allow_js_trusted', $_POST['uri_allow_js_trusted'] );
}
//add_action( 'personal_options_update', 'uri_allow_js_save_profile_fields' );
add_action( 'edit_user_profile_update', 'uri_allow_js_save_profile_fields' );


/**
 * Checks if the current user can update the js settings.
 * @return bool
 */
function _uri_user_can_update() {
	// only show the field for users who can activate the plugin
	return current_user_can( 'activate_plugins' );
}
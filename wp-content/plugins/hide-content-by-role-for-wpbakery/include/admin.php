<?php

new HCBRWPB_Admin();

class HCBRWPB_Admin {

	function __construct() {

		add_action( 'vc_after_mapping', [ $this, 'vc_before_init_actions' ] );

	}

	function vc_before_init_actions() {

		if ( ! function_exists( 'get_editable_roles' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/user.php' );
		}

		$roles = get_editable_roles();

		$values = array();
		// Logged out users
		$values[__( "Logged-out users", 'hide-content-by-role-for-wpbakery' )] = 'logged_out';
		foreach ( $roles as $role_key => $role_value ) {
			$values[ $role_value['name'] ] = $role_key;
		}

		$elements = WPBMap::getAllShortCodes();

		$shortcodes_to_add_options = array_keys($elements);

		$shortcodes_to_add_options = apply_filters('hcbrwpb_shortcodes_to_add_options', $shortcodes_to_add_options);

		foreach ($shortcodes_to_add_options as $shortcode){
			vc_add_param( $shortcode, array(
				"type"       => "checkbox",
				"group"      => __( "Visible for roles", 'hide-content-by-role-for-wpbakery' ),
				"class"      => "",
				"description" => __( "Leave all empty to show for any user role", 'hide-content-by-role-for-wpbakery' ),
				"heading"    => __( "Visible for roles", 'hide-content-by-role-for-wpbakery' ),
				"param_name" => "hcbrwpb_visible_for_roles",
				"value"      => $values
			) );
		}

	}

}
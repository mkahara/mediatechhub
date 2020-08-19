<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add custom plugin CSS classes to the admin body classes
 *
 */
function kbe_admin_body_class( $classes ) {

	$screen = get_current_screen();

	if( empty( $screen ) )
		return $classes;

	if( ! empty( $_GET['page'] ) && false !== strpos( $_GET['page'], 'kbe' ) )
		$classes .= ' kbe-pagestyles';

	if( $screen->base == 'post' && $screen->post_type == 'kbe_knowledgebase' )
		$classes .= ' kbe-pagestyles-edit-post';

	return $classes;

}
add_filter( 'admin_body_class', 'kbe_admin_body_class' );


/**
 * Enqueue scripts.
 *
 * Enqueue the required stylesheets and javascripts in the admin.
 *
 * @param string $hook_suffix Current page ID.
 *
 */
function kbe_admin_scripts( $hook_suffix ) {

	// Settings page
	if( $hook_suffix == 'kbe_knowledgebase_page_kbe_options' || get_post_type() == 'kbe_knowledgebase' ) {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'kbe-script', WP_KNOWLEDGEBASE . 'assets/js/script-admin.js', array( 'wp-color-picker' ), false, true );

		// Select2
		wp_register_script( 'select2-js', WP_KNOWLEDGEBASE . 'assets/libs/select2/select2.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'select2-js' );

		wp_register_style( 'select2-css', WP_KNOWLEDGEBASE . 'assets/libs/select2/select2.min.css' );
		wp_enqueue_style( 'select2-css' );

	}

	// Order page
	if ( $hook_suffix == 'kbe_knowledgebase_page_kbe_order' ) {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	// Old plugin styles
	wp_register_style( 'kbe_admin_css', WP_KNOWLEDGEBASE . '/assets/css/kbe-admin-style.css' );
	if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'kbe_knowledgebase' ) {
		wp_enqueue_style( 'kbe_admin_css' );
	}

	// New plugin styles
	wp_register_style( 'kbe-style', WP_KNOWLEDGEBASE . '/assets/css/style-admin.css' );
	if ( ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'kbe_knowledgebase' ) || get_post_type() == 'kbe_knowledgebase' ) {
		wp_enqueue_style( 'kbe-style' );
	}

}
add_action( 'admin_enqueue_scripts', 'kbe_admin_scripts' );


/**
 * Add submenus.
 *
 * Add submenus for the custom added pages.
 *
 * @since 1.0
 *
 */
function kbe_plugin_menu() {

	add_submenu_page( 'edit.php?post_type=kbe_knowledgebase', __( 'Order', 'wp-knowledgebase' ), __( 'Order', 'wp-knowledgebase' ), 'manage_options', 'kbe_order', 'wp_kbe_order' );
	add_submenu_page( 'edit.php?post_type=kbe_knowledgebase', __( 'Settings', 'wp-knowledgebase' ), __( 'Settings', 'wp-knowledgebase' ), 'manage_options', 'kbe_options', 'wp_kbe_options' );

}
add_action( 'admin_menu', 'kbe_plugin_menu' );


/**
 * Output order page.
 *
 * Output the HTML for the 'order' page.
 *
 * @since 1.0
 */
function wp_kbe_order() {

	require dirname( __FILE__ ) . '/kbe-order.php';

}


/**
 * Output settings page.
 *
 * Output the HTML for the settings page.
 *
 * @since 1.0
 */
function wp_kbe_options() {

	require 'kbe-settings.php';

}


/**
 * Register the plugin's general settings
 *
 */
function kbe_register_settings() {

	// Register each setting for automated $_POST handling
	foreach ( kbe_get_settings() as $id => $setting ) {

		switch ( $setting['type'] ) {

			case 'number' :
				$sanitize_callback = 'absint';
				break;
			case 'text' :
				$sanitize_callback = 'sanitize_text_field';
				break;
			case 'title' :
				$sanitize_callback = 'sanitize_title';
				break;
			case 'array' :
				$sanitize_callback = '_kbe_array_wp_kses_post';
				break;
			case 'kbe_radio_switch' :
				$sanitize_callback = 'sanitize_kbe_radio_switch';
				break;
			default:
				$sanitize_callback = 'wp_kses_post';

		}

		register_setting( 'kbe_settings', $id, $sanitize_callback );

	}

}
add_action( 'admin_init', 'kbe_register_settings' );


/**
 * Returns the plugin's settings options
 *
 * @return array
 *
 */
function kbe_get_settings() {

	$settings = array(
		'kbe_plugin_slug' => array(
			'type' => 'title',
		),
		'kbe_article_qty' => array(
			'type' => 'number',
		),
		'kbe_search_setting' => array(
			'type' => 'kbe_radio_switch_on_off',
		),
		'kbe_search_field_placeholder' => array(
			'type' => 'text'
		),
		'kbe_search_no_results_message' => array(
			'type' => 'text_html'
		),
		'kbe_breadcrumbs_setting' => array(
			'type' => 'kbe_radio_switch_on_off',
		),
		'kbe_breadcrumbs_separator' => array(
			'type' => 'text_html'
		),
		'kbe_search_excerpt' => array(
			'type' => 'kbe_radio_switch_on_off',
		),
		'kbe_sidebar_home' => array(
			'type' => 'kbe_radio_switch_lrn', // left, right, none option
		),
		'kbe_sidebar_inner' => array(
			'type' => 'kbe_radio_switch_lrn', // left, right, none option
		),
		'kbe_comments_setting' => array(
			'type' => 'kbe_radio_switch_on_off',
		),
		'kbe_output_style' => array(
			'type' => 'kbe_radio_switch_on_off',
		),
		'kbe_bgcolor' => array(
			'type' => 'color',
		),
		'kbe_wipe_uninstall' => array(
			'type' => 'kbe_radio_switch_on_off',
		)
	);

	/**
	 * Filter the settings array
	 *
	 * @param array $settings
	 *
	 */
	return apply_filters( 'kbe_settings', $settings );

}

function kbe_radio_switch_on_off( $v ) {
	if ( $v == 1 ) {
		return 1;
	}
	return 0;
}

function kbe_radio_switch_lrn( $v ) {
	if ( $v == 1 ) {
		return 1;
	} elseif ( $v == 2 ) {
		return 2;
	}
	return 0;
}

/**
 * Sanitizes the values of an array recursivelly and allows HTML tags
 *
 * @param array $array
 *
 * @return array
 *
 */
function _kbe_array_wp_kses_post( $array = array() ) {

    if( empty( $array ) || ! is_array( $array ) )
        return array();

    foreach( $array as $key => $value ) {

        if( is_array( $value ) )
            $array[$key] = _kbe_array_wp_kses_post( $value );

        else
            $array[$key] = wp_kses_post( $value );

    }

    return $array;

}


/**
 * Migrations check
 *
 */
function kbe_migrations_check() {

	require_once plugin_dir_path( __FILE__ ) . '../migrations/class-migration-manager.php';
	$migration_manager = new KBE_Migration_Manager( 'wp-knowledgebase' );

}
add_action( 'admin_init', 'kbe_migrations_check' );
register_activation_hook( __FILE__, 'kbe_migrations_check' );


/**
 * Determines whether or not there are WP Knowledgebase add-ons on the server
 *
 * @return bool
 *
 */
function kbe_add_ons_exist() {

	$plugins = get_plugins();

	foreach( $plugins as $plugin_slug => $plugin_details ) {

		if( 0 === strpos( $plugin_slug, 'wp-knowledgebase-add-on' ) )
			return true;

	}

	return false;

}


/**
 * Determines whether the current website is registered with a license key or not
 *
 * @return bool
 *
 */
function kbe_is_website_registered() {

	$registered = get_option( 'kbe_website_registered' );

	return ( false === $registered ? false : true );

}


/**
 * Add admin notice to anounce version 1.2.4
 *
 */
function kbe_admin_notice_plugin_version_1_2_4() {

	if( time() > strtotime( '01-08-2020' ) )
		return;

	// Do not display this notice if user cannot activate plugins
	if( ! current_user_can( 'activate_plugins' ) )
		return;

	// Do not display this notice for users that have dismissed it
	if( get_user_meta( get_current_user_id(), 'kbe_admin_notice_plugin_version_1_2_4', true ) != '' )
		return;

	// Echo the admin notice
	echo '<div class="notice notice-info" style="padding: 15px 15px 12px 15px;">';

		echo '<img src="' . WP_KNOWLEDGEBASE . '/assets/images/kbe-logo.png" style="max-width: 28px; width: auto; margin-right: 10px; vertical-align: middle;" />';
		echo '<h4 style="display: inline-block; vertical-align: middle; font-size: 16px; margin: 0;">WP Knowledgebase</h4>';

    	echo '<p style="margin-top: 15px; font-size: 14px;">' . sprintf( __( "You can now restrict access to your knowledge base main page, categories and articles with the %sContent Restriction add-on%s.", 'wp-knowledgebase' ), '<strong>', '</strong>' ) . '</p>';

    	echo '<p>';
    		echo '<a class="button-primary" target="_blank" href="https://usewpknowledgebase.com/" style="margin-right: 10px;">Learn more</a>';
    		echo '<a href="' . add_query_arg( array( 'kbe_admin_notice_plugin_version_1_2_4' => 1 ) ) . '">' . __( 'Dismiss notice', 'wp-knowledgebase' ) . '</a>';
    	echo '</p>';

    echo '</div>';

}
add_action( 'admin_notices', 'kbe_admin_notice_plugin_version_1_2_4' );


/**
 * Handle admin notices dismissals
 *
 */
function kbe_admin_notice_dismiss() {

	// Do nothing if the user doesn't have privileges
	if( ! current_user_can( 'activate_plugins' ) )
		return;

	if( isset( $_GET['kbe_admin_notice_plugin_version_1_2_4'] ) )
		add_user_meta( get_current_user_id(), 'kbe_admin_notice_plugin_version_1_2_4', 1, true );

}
add_action( 'admin_init', 'kbe_admin_notice_dismiss' );


/**
 * Adds external links to the admin submenu
 *
 */
function kbe_add_admin_menu_external_items() {

	global $submenu;

	if( empty( $submenu ) || ! is_array( $submenu ) )
		return;

	if( ! isset( $submenu['edit.php?post_type=kbe_knowledgebase'] ) )
		return;

	$submenu['edit.php?post_type=kbe_knowledgebase'][1000] = array( __( 'Need help?', 'wp-knowledgebase' ), 'manage_options', 'https://usewpknowledgebase.com/contact/' );

}
add_action( 'admin_init', 'kbe_add_admin_menu_external_items', 1000 );


/**
 * Adds a script to make external links to the site open in a new tab
 *
 */
function kbe_external_menu_items_script() {
	?>

	<script>
		jQuery( function($) {
			$('a[href="https://usewpknowledgebase.com/contact/"]').attr( 'target', '_blank' );
		});
	</script>

	<?php
}
add_action( 'admin_footer', 'kbe_external_menu_items_script', 1000 );
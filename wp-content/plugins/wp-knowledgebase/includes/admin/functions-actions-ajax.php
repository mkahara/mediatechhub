<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Attempts to register a website with our server
 *
 */
function kbe_action_ajax_register_website() {

	if( empty( $_POST['kbe_token'] ) || ! wp_verify_nonce( $_POST['kbe_token'], 'kbe_save_settings' ) )
		wp_die(0);

	if( empty( $_POST['license_key'] ) )
		wp_die(0);

	$license_key = sanitize_text_field( $_POST['license_key'] );
	$website_url = get_site_url();

	// Call the API link
	$response = wp_remote_get( add_query_arg( array( 'edde_api_action' => 'register_website', 'license_key' => $license_key, 'url' => $website_url ), 'https://usewpknowledgebase.com/' ), array( 'timeout' => 30, 'sslverify' => false ) );

	// If the connection isn't successfull, return
	if( is_wp_error( $response ) ) {

		wp_send_json( array( 'success' => false, 'data' => array( 'message' => __( 'Something went wrong. Could not activate the website. Please try again.', 'wp-knowledgebase' ) ) ) );

	}

	// Get the response's body
	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	// If the website could not be registered, return the error
	if( ! empty( $body['error'] ) ) {

		wp_send_json( array( 'success' => false, 'data' => array( 'message' => kbe_get_api_action_response_error( 'register_website', $body['error'] ) ) ) );

	}

	// Save the license key
	update_option( 'kbe_license_key', $license_key );

	// Save license key data
	update_option( 'kbe_license_key_data', $body );

	// Set the website as registered
	update_option( 'kbe_website_registered', true );

	// Return with a success message
	wp_send_json( array( 'success' => true, 'data' => array( 'message' => __( 'Your website has been successfully registered.', 'wp-knowledgebase' ) ) ) );

}
add_action( 'wp_ajax_kbe_action_ajax_register_website', 'kbe_action_ajax_register_website' );


/**
 * Attempts to deregister a website from our server
 *
 */
function kbe_action_ajax_deregister_website() {

	if( empty( $_POST['kbe_token'] ) || ! wp_verify_nonce( $_POST['kbe_token'], 'kbe_save_settings' ) )
		wp_die(0);

	if( empty( $_POST['license_key'] ) )
		wp_die(0);

	$license_key = sanitize_text_field( $_POST['license_key'] );
	$website_url = get_site_url();

	// Call the API link
	$response = wp_remote_get( add_query_arg( array( 'edde_api_action' => 'deregister_website', 'license_key' => $license_key, 'url' => $website_url ), 'https://usewpknowledgebase.com/' ), array( 'timeout' => 30, 'sslverify' => false ) );

	// If the connection isn't successfull, return
	if( is_wp_error( $response ) ) {

		wp_send_json( array( 'success' => false, 'data' => array( 'message' => __( 'Something went wrong. Could not activate the website. Please try again.', 'wp-knowledgebase' ) ) ) );

	}

	// Get the response's body
	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	// If the website could not be registered, return the error
	if( ! empty( $body['error'] ) ) {

		wp_send_json( array( 'success' => false, 'data' => array( 'message' => kbe_get_api_action_response_error( 'deregister_website', $body['error'] ) ) ) );

	}

	// Save the license key
	delete_option( 'kbe_license_key' );

	// Save license key data
	delete_option( 'kbe_license_key_data' );

	// Set the website as registered
	delete_option( 'kbe_website_registered' );

	// Return with a success message
	wp_send_json( array( 'success' => true, 'data' => array( 'message' => __( 'Your website has been successfully deregistered.', 'wp-knowledgebase' ) ) ) );

}
add_action( 'wp_ajax_kbe_action_ajax_deregister_website', 'kbe_action_ajax_deregister_website' );


/**
 * Returns a user friendly error message for the provided API action and error code,
 * when we are connecting to WP Knowledgebase website's API
 *
 * @param string $action
 * @param string $error_code
 *
 * @return string
 *
 */
function kbe_get_api_action_response_error( $action, $error_code ) {

    $error_messages = array(
        'register_website' => array(
            'license_is_null'          => __( "The provided license key does not exist or is invalid.", 'wp-knowledgebase' ),
            'license_inactive'         => __( "The provided license key is inactive.", 'wp-knowledgebase' ),
            'license_expired'          => __( "The provided license key is expired.", 'wp-knowledgebase' ),
            'activation_limit_reached' => __( "Your activation limit for this license key has been reached. Please upgrade your account if you'd like to register more websites.", 'wp-knowledgebase' ),
            'register_website_failed'  => __( "Something went wrong. Could not activate the website. Please try again.", 'wp-knowledgebase' )
        ),
        'deregister_website' => array(
            'license_is_null'           => __( "The provided license key does not exist or is invalid.", 'wp-knowledgebase' ),
            'website_is_null'           => __( "This website is not registered on our system.", 'wp-knowledgebase' ),
            'deregister_website_failed' => __( "Something went wrong. Could not activate the website. Please try again.", 'wp-knowledgebase' )
        )
    );

    return ( ! empty( $error_messages[$action][$error_code] ) ? $error_messages[$action][$error_code] : '' );

}
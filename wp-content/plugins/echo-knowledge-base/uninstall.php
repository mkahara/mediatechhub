<?php
// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

/**
 * Uninstall this plugin
 */
class KB_Uninstall {

	// Prefix for custom post type name associated with given KB; this will never change
	const KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update
	const KB_CATEGORY_TAXONOMY_SUFFIX = '_category';  // changing this requires db update; do not translate
	const KB_TAG_TAXONOMY_SUFFIX = '_tag'; // changing this requires db update; do not translate

	public function __construct() {

        flush_rewrite_rules(false);

        delete_option( 'epkb_error_log' );
        delete_option( 'epkb_flush_rewrite_rules' );

        $delete_data = get_option( 'epkb_delete_all_kb_data' );
        if ( ! empty( $delete_data ) && $delete_data == 'delete' ) {
			$this->uninstall_kb();
        }
    }

    /**
     * Removes ALL plugin data for KB #1
     * only when the relevant option is active
     *
     */
    private function uninstall_kb()     {
    	/** @global wpdb $wpdb */
		global $wpdb;

        delete_option( 'epkb_version' );
        delete_option( 'epkb_version_first' );
        delete_option( 'epkb_config_1' );
        delete_option( 'epkb_orignal_config_1' );
        delete_option( 'epkb_articles_sequence_1' );
        delete_option( 'epkb_categories_sequence_1' );
        delete_option( 'epkb_categories_icons_images_1' );
		delete_option( 'epkb_post_type_1_category_children' );
        delete_option( 'epkb_long_notices' );
        delete_option( 'epkb_one_time_notices' );
        delete_option( 'epkb_delete_all_kb_data' );
        delete_option( 'epkb_show_upgrade_message' );
		delete_transient( '_epkb_plugin_activated' );

	    delete_option( 'asea_version' );
	    delete_option( 'asea_version_first' );
	    delete_option( 'asea_error_log' );
	    delete_option( 'asea_license_key' );
	    delete_option( 'asea_license_state' );

	    delete_option( 'elay_version' );
	    delete_option( 'elay_version_first' );
	    delete_option( 'elay_error_log' );
	    delete_option( 'elay_license_key' );
	    delete_option( 'elay_license_state' );

	    delete_option( 'eprf_version' );
	    delete_option( 'eprf_version_first' );
	    delete_option( 'eprf_error_log' );
	    delete_option( 'eprf_license_key' );
	    delete_option( 'eprf_license_state' );

	    delete_option( 'epie_version' );
	    delete_option( 'epie_version_first' );
	    delete_option( 'epie_error_log' );
	    delete_option( 'epie_license_key' );
	    delete_option( 'epie_license_state' );

	    delete_option( 'kblk_version' );
	    delete_option( 'kblk_version_first' );
	    delete_option( 'kblk_error_log' );
	    delete_option( 'kblk_license_key' );
	    delete_option( 'kblk_license_state' );

	    delete_option( 'emkb_version' );
	    delete_option( 'emkb_version_first' );
	    delete_option( 'emkb_error_log' );
	    delete_option( 'emkb_license_key' );
	    delete_option( 'emkb_license_state' );

	    delete_option( 'widg_version' );
	    delete_option( 'widg_version_first' );
	    delete_option( 'widg_error_log' );
	    delete_option( 'widg_license_key' );
	    delete_option( 'widg_license_state' );

	    // Remove all database tables
	    $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "epkb_kb_search_data" );
	    $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "epkb_article_ratings" );
    }
}

new KB_Uninstall();
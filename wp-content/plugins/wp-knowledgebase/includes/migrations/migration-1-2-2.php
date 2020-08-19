<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class KBE_Migration_1_2_2
 *
 * Migration that runs when updating to version 1.2.2
 *
 */
class KBE_Migration_1_2_2 extends KBE_Abstract_Migration {


	/**
	 * Constructor.
	 *
	 */
	public function __construct() {
		$this->id          = 'kbe-install-1-2-2';
		$this->notice_type = 'none';

		parent::__construct();
	}

	/**
	 * Actually run the migration.
	 *
	 */
	public function migrate() {

		flush_rewrite_rules();

		add_option( 'kbe_search_field_placeholder', __( 'Search articles...', 'wp-knowledgebase' ) );
		add_option( 'kbe_search_no_results_message', __( 'No results found.', 'wp-knowledgebase' ) );
		add_option( 'kbe_breadcrumbs_separator', '/' );

		return true;

	}

}
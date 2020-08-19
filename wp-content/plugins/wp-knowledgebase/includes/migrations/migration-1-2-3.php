<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Class KBE_Migration_1_2_3
 *
 * Migration that runs when updating to version 1.2.3
 *
 */
class KBE_Migration_1_2_3 extends KBE_Abstract_Migration {


	/**
	 * Constructor.
	 *
	 */
	public function __construct() {
		$this->id          = 'kbe-install-1-2-3';
		$this->notice_type = 'none';

		parent::__construct();
	}

	/**
	 * Actually run the migration.
	 *
	 */
	public function migrate() {

		flush_rewrite_rules();

		add_option( 'kbe_output_style', 1 );

		return true;

	}

}
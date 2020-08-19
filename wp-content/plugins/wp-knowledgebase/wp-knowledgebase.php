<?php
/**
 * Plugin Name: WP Knowledgebase
 * Plugin URI: http://wordpress.org/plugins/wp-knowledgebase
 * Description: Simple and flexible knowledgebase plugin for WordPress
 * Version: 1.2.4
 * Author: Mihai Iova
 * Author URI: https://usewpknowledgebase.com/
 * Text Domain: wp-knowledgebase
 * License: GPL2
 *
 * == Copyright ==
 * Copyright 2020 WP Knowledgebase
 *	
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Main plugin class
 *
 */
Class WP_Knowledgebase {

	/**
	 * Whether to run the update procedure or not
	 *
	 * @access private
	 * @var    bool
	 *
	 */
	private $do_update = false;

	/**
	 * The current object instance
	 *
	 * @access private
	 * @var    WP_Knowledgebase
	 *
	 */
	private static $instance;

	/**
	 * A list with the objects that handle database requests
	 *
	 * @access public
	 * @var    array
	 *
	 */
	public $db = array();


	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		// Defining new constants
		define( 'KBE_PLUGIN_VERSION', '1.2.4' );
		define( 'KBE_BASENAME',  	  plugin_basename( __FILE__ ) );
		define( 'KBE_PLUGIN_DIR', 	  plugin_dir_path( __FILE__ ) );
		define( 'KBE_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

		$this->include_files();
		$this->load_db_layer();

		// Defining legacy constants
		define( 'WP_KNOWLEDGEBASE', plugin_dir_url( __FILE__ ) );
		define( 'KBE_ARTICLE_QTY', get_option( 'kbe_article_qty' ) );
		define( 'KBE_PLUGIN_SLUG', get_option( 'kbe_plugin_slug' ) );
		define( 'KBE_SEARCH_SETTING', get_option( 'kbe_search_setting' ) );
		define( 'KBE_BREADCRUMBS_SETTING', get_option( 'kbe_breadcrumbs_setting' ) );
		define( 'KBE_SIDEBAR_HOME', get_option( 'kbe_sidebar_home' ) );
		define( 'KBE_SIDEBAR_INNER', get_option( 'kbe_sidebar_inner' ) );
		define( 'KBE_COMMENT_SETTING', get_option( 'kbe_comments_setting' ) );
		define( 'KBE_BG_COLOR', get_option( 'kbe_bgcolor' ) );
		define( 'KBE_LINK_STRUCTURE', get_option( 'permalink_structure' ) );
		define( 'KBE_POST_TYPE', 'kbe_knowledgebase' );
		define( 'KBE_POST_TAXONOMY', 'kbe_taxonomy' );
		define( 'KBE_POST_TAGS', 'kbe_tags' );
		define( 'KBE_PAGE_TITLE', kbe_get_knowledgebase_page_id() );


		// Load plugin textdomain
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ), 15 );

        // Verifies if an update is needed
        add_action( 'plugins_loaded', array( $this, 'set_do_update' ), 15 );

		// Check if just updated
		add_action( 'plugins_loaded', array( $this, 'update_check' ), 20 );

		// Update the database tables
		add_action( 'kbe_update_check', array( $this, 'update_database_tables' ) );

        // Remove plugin query args from the URL
        add_filter( 'removable_query_args', array( $this, 'removable_query_args' ) );

        // Add extra action links to the plugin in Plugins list table
        add_filter( 'plugin_action_links_' . KBE_BASENAME, array( $this, 'add_plugin_action_links' ) );

        // Set and unset cron jobs
        register_activation_hook( __FILE__, array( $this, 'set_cron_jobs' ) );
        register_deactivation_hook( __FILE__, array( $this, 'unset_cron_jobs' ) );

        // Set fresh install transient
        register_activation_hook( __FILE__, array( $this, 'set_activation_transient' ) );

        /**
         * Plugin initialized
         *
         */
        do_action( 'kbe_initialized' );

	}

	/**
	 * Returns an instance of the plugin object
	 *
	 * @return WP_Knowledgebase
	 *
	 */
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WP_Knowledgebase ) )
			self::$instance = new WP_Knowledgebase;

		return self::$instance;

	}


	/**
     * Loads plugin text domain
     *
     */
    public function load_textdomain() {

    	$locale = apply_filters( 'plugin_locale', get_locale(), 'wp-knowledgebase' );

		// Load textdomain
		load_textdomain( 'wp-knowledgebase', WP_LANG_DIR . '/wp-knowledgebase/wp-knowledgebase-' . $locale . '.mo' );

        $current_theme = wp_get_theme();

        if( ! empty( $current_theme->stylesheet ) && file_exists( get_theme_root() . '/' . $current_theme->stylesheet . '/wp_knowledgebase/languages/' ) )
            load_plugin_textdomain( 'wp-knowledgebase', false, plugin_basename( dirname( __FILE__ ) ) . '/../../themes/' . $current_theme->stylesheet . '/wp_knowledgebase/languages/' );
        else
            load_plugin_textdomain( 'wp-knowledgebase', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

    }


	/**
	 * Include files
	 *
	 * @return void
	 *
	 */
	public function include_files() {

		/**
		 * Include abstract classes
		 *
		 */
		$abstracts = scandir( KBE_PLUGIN_DIR . 'includes/abstracts' );

		foreach( $abstracts as $abstract ) {

			if( false === strpos( $abstract, '.php' ) )
				continue;

			include KBE_PLUGIN_DIR . 'includes/abstracts/' . $abstract;

		}

		/**
		 * Include all functions.php files from all plugin folders
		 *
		 */
		$this->_recursively_include_files( KBE_PLUGIN_DIR . 'includes' );


		//  Require File kbe_articles.php
		require 'includes/kbe-articles.php';
		require 'includes/kbe-template-functions.php';
		require 'includes/kbe-core-functions.php';

		//  Require Category Widget file
		require 'includes/widgets/kbe-widget-category.php';
		//  Require Articles Widget file
		require 'includes/widgets/kbe-widget-article.php';
		//  Require Search Articles Widget file
		require 'includes/widgets/kbe-widget-search.php';
		//  Require Tags Widget file
		require 'includes/widgets/kbe-widget-tags.php';

		// Include update checker
		require 'includes/class-update-checker.php';


		// Include admin file(s)
		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			require 'includes/admin/kbe-admin-functions.php';
			require 'includes/admin/functions-promo.php';
		}

		if( is_admin() ) {
			require 'includes/admin/functions-actions-ajax.php';
		}

		// Include migrations
		require 'includes/migrations/class-abstract-migration.php';
		require 'includes/migrations/migration-install.php';

		// Include the deactivation class
		require 'includes/class-deactivation.php';


		/**
		 * Helper hook to include files early
		 *
		 */
		do_action( 'kbe_include_files' );

	}


	/**
	 * Recursively includes all functions.php files from the given directory path
	 *
	 * @param string $dir_path
	 *
	 */
	protected function _recursively_include_files( $dir_path ) {

		$folders = array_filter( glob( $dir_path . '/*' ), 'is_dir' );

		foreach( $folders as $folder_path ) {

			if( file_exists( $folder_path . '/functions.php' ) )
				include $folder_path . '/functions.php';

			$this->_recursively_include_files( $folder_path );

		}

	}


	/**
	 * Sets up all objects that handle database related requests and adds them to the
	 * $db property of the app
	 *
	 */
	public function load_db_layer() {

		/**
		 * Hook to register db class handlers
		 * The array element should be 'class_slug' => 'class_name'
		 *
		 * @param array
		 *
		 */
		$db_classes = apply_filters( 'kbe_register_database_classes', array() );

		if( empty( $db_classes ) )
			return;

		foreach( $db_classes as $db_class_slug => $db_class_name ) {

			$this->db[$db_class_slug] = new $db_class_name;

		}

	}


	/**
	 * Verifies whether the update procedure should run or not.
	 *
	 */
	public function set_do_update() {

		$db_version = get_option( 'kbe_version', '' );

		// If current version number differs from saved version number
		if( $db_version != KBE_PLUGIN_VERSION ) {

			$this->do_update = true;

		}

		/**
		 * Filter to change do_update if needed
		 *
		 * @param bool
		 *
		 */
		$this->do_update = apply_filters( 'kbe_update_check_do_update', $this->do_update );

	}


	/**
	 * Checks to see if the current version of the plugin matches the version
	 * saved in the database
	 *
	 * @return void 
	 *
	 */
	public function update_check() {

		if( ! $this->do_update )
			return;

		$db_version = get_option( 'kbe_version', '' );

		// Update the version number in the db
		update_option( 'kbe_version', KBE_PLUGIN_VERSION );

		// Add first activation time
		if( get_option( 'kbe_first_activation', '' ) == '' ) {

			update_option( 'kbe_first_activation', time() );

			/**
			 * Hook for first time activation
			 *
			 */
			do_action( 'kbe_first_activation', $db_version );

		}

		/**
		 * Hook for fresh update
		 *
		 */
		do_action( 'kbe_update_check', $db_version );

		// Trigger set cron jobs
		$this->set_cron_jobs();

	}


	/**
	 * Creates and updates the database tables 
	 *
	 * @return void
	 *
	 */
	public function update_database_tables() {

		foreach( $this->db as $db_class ) {

			$db_class->create_table();

		}

	}


	/**
	 * Sets an action hook for modules to add custom schedules
	 *
	 */
	public function set_cron_jobs() {

		do_action( 'kbe_set_cron_jobs' );

	}


	/**
	 * Sets an action hook for modules to remove custom schedules
	 *
	 */
	public function unset_cron_jobs() {

		do_action( 'kbe_unset_cron_jobs' );

	}


	/**
	 * Sets a transient right at activation time
	 *
	 */
	public function set_activation_transient() {

		set_transient( '_kbe_activated', 1, 60 );

	}


	/**
	 * Add extra action links in the plugins page
	 *
	 * @param array $links
	 *
	 * @return array
	 *
	 */
	public function add_plugin_action_links( $links ) {

	  $links[] = '<a href="' . esc_url( add_query_arg( array( 'post_type' => KBE_POST_TYPE, 'page' => 'kbe_options' ), admin_url( 'edit.php' ) ) ) . '">' . __( 'Settings', 'wp-knowledgebase' ) . '</a>';

	  return $links;

	}


	/**
	 * Removes the query variables from the URL upon page load
	 *
	 */
	public function removable_query_args( $args = array() ) {

		$args[] = 'kbe_message';

		return $args;

	}

}


/**
 * Main plugin function
 *
 */
function wp_knowledgebase() {

	return WP_Knowledgebase::instance();

}

// Let's get this party started
wp_knowledgebase();
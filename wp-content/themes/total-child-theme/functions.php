<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: wpex
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function total_child_enqueue_parent_theme_style() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'Total' );
	$version = $theme->get( 'Version' );

	// Load the stylesheet
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), $version );

}
add_action( 'wp_enqueue_scripts', 'total_child_enqueue_parent_theme_style' );

// Add custom font to font settings
function wpex_add_custom_fonts() {
	return array( 'CircularBold'=>'CircularBold',
					'CircularBook'=>'CircularBook',
					'CircularMedium'=>'CircularMedium',
					);
}

function searchbar( $form ) {

	$form = '<form role="search" method="get" id="searchform" action="'. home_url( ‘/’ ) .'">
	<div><label class="screen-reader-text" for="s">'. __('Search for:') .'</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="Type here..." />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</div>
	</form>';
	
	return $form;
	}
	
	add_shortcode('searchbar', 'searchbar');
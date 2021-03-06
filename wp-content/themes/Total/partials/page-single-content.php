<?php
/**
 * Page Content
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 4.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="single-content single-page-content entry clr"><?php the_content(); ?></div>

<?php
// Page links (for the <!-nextpage-> tag)
wpex_get_template_part( 'link_pages' ); ?>
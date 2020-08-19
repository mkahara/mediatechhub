<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Adds a promotional card to the bottom of the settings page to promote
 * the content restriction add-on
 *
 */
function kbe_view_promo_content_restriction() {

	if( kbe_is_website_registered() || class_exists( 'KBE_Content_Restriction' ) )
		return;

	?>

		<!-- Content Restriction -->
        <div class="kbe-card">

            <div class="kbe-card-header">
                <?php echo __( 'Content Restriction', 'wp-knowledgebase' ); ?>
            </div>

            <div class="kbe-card-inner">

            	<div style="position: relative; background: #f6f6f6; border-radius: 4px; padding: 15px 15px 15px 60px;">
	                <span class="dashicons dashicons-lock" style="position: absolute; top: 15px; left: 15px; font-size: 30px; width: 30px; height: 30px;"></span>
	                <p style="margin-top: 0;"><?php echo __( 'Restrict access, by user role or individual users, to your knowledgebase articles and redirect unauthorized users to a custom link.', 'wp-knowledgebase' ); ?></p>
	                <a href="http://usewpknowledgebase.com/" target="_blank" class="kbe-button-secondary"><?php echo __( 'Learn more', 'wp-knowledgebase' ) ?></a>
	            </div>

            </div>

        </div><!-- / Content Restriction -->

	<?php

}
add_action( 'kbe_view_settings_tab_general_bottom', 'kbe_view_promo_content_restriction' );
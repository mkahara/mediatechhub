<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php
/*
<div id="wpbody">
    <div id="wpbody-content">
        <div class="wrap">

            <h2><?php _e( 'Knowledgebase Display Settings', 'wp-knowledgebase' ); ?></h2><?php

				settings_errors( 'general' );

				global $wpdb;

				$tbl_posts = $wpdb->prefix . 'posts';

				if ( isset( $kbe_settings['update'] ) ) {
					$kbe_posts = $wpdb->get_results( "Select * From $tbl_posts Where post_content like '%[kbe_knowledgebase]%' and post_type = 'page'" );

					foreach ( $kbe_posts as $kbe_post ) {
						$kbe_id   = $kbe_post->ID;
						$kbe_slug = get_option( 'kbe_plugin_slug' );

						$kbe_post_data = array(
							'post_name' => $kbe_slug
						);

						$kbe_post_where = array(
							'ID' => $kbe_id
						);

						$wpdb->update( $tbl_posts, $kbe_post_data, $kbe_post_where );
					}
					flush_rewrite_rules();

					?><div class='updated' style='margin-top:10px;'>
                        <p><?php _e( 'Settings updated successfully', 'wp-knowledgebase' ); ?></p>
                    </div><?php

					unset( $kbe_settings['update'] );
					update_option( 'kbe_settings', $kbe_settings );
				}

			?><div class="kbe_admin_left_bar">
                <div class="kbe_admin_left_content">
                    <div class="kbe_admin_left_heading">
                        <h3><?php _e( 'Settings', 'wp-knowledgebase' ); ?></h3>
                    </div>
                    <div class="kbe_admin_settings">
                        <form method="post" action="options.php"><?php

							settings_fields( 'kbe_settings' );

							?><table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 18px;">
                                <tr>
                                    <td width="40%" valign="top">
                                        <label><?php _e( 'Knowledgebase Slug', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" name="kbe_plugin_slug" id="kbe_plugin_slug" value="<?php echo esc_attr( get_option( 'kbe_plugin_slug', 'knowledgebase' ) ); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Number of articles to show', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" name="kbe_article_qty" id="kbe_article_qty" value="<?php echo esc_attr( get_option( 'kbe_article_qty', 5 ) ); ?>">
                                    <p>
                                        <strong><?php _e( 'Note:', 'wp-knowledgebase' ); ?></strong>
                                        <?php _e( 'Set the number of articles to show in each category on KB homepage', 'wp-knowledgebase' ); ?>
                                    </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Knowledgebase search', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td width="15%">
                                        <input type="radio" name="kbe_search_setting" id="kbe_search_setting" value="1" <?php checked( get_option( 'kbe_search_setting', 0 ), '1' ); ?>>
                                        <span><?php _e( 'On', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td width="15%">
                                        <input type="radio" name="kbe_search_setting" id="kbe_search_setting" value="0" <?php checked( get_option( 'kbe_search_setting', 0 ), '0' ); ?>>
                                        <span><?php _e( 'Off', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td width="45%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Knowledgebase breadcrumbs', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_breadcrumbs_setting" id="kbe_breadcrumb_setting" value="1" <?php checked( get_option( 'kbe_breadcrumbs_setting', 0 ), '1' ); ?>>
                                        <span><?php _e( 'On', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_breadcrumbs_setting" id="kbe_breadcrumb_setting" value="0" <?php checked( get_option( 'kbe_breadcrumbs_setting', 0 ), '0' ); ?>>
                                        <span><?php _e( 'Off', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Knowledgebase home page sidebar', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_sidebar_home" id="kbe_sidebar_home" value="1" <?php checked( get_option( 'kbe_sidebar_home', 0 ), 1 ); ?>>
                                        <span><?php _e( 'Left', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_sidebar_home" id="kbe_sidebar_home" value="2" <?php checked( get_option( 'kbe_sidebar_home', 0 ), 2 ); ?>>
                                        <span><?php _e( 'Right', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_sidebar_home" id="kbe_sidebar_home" value="0" <?php checked( get_option( 'kbe_sidebar_home', 0 ), 0 ); ?>>
                                        <span><?php _e( 'None', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Knowledgebase inner pages sidebar', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_sidebar_inner" id="kbe_sidebar_inner" value="1" <?php checked( get_option( 'kbe_sidebar_inner', 0 ), 1 ); ?>>
                                        <span><?php _e( 'Left', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_sidebar_inner" id="kbe_sidebar_inner" value="2" <?php checked( get_option( 'kbe_sidebar_inner', 0 ), 2 ); ?>>
                                        <span><?php _e( 'Right', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_sidebar_inner" id="kbe_sidebar_inner" value="0" <?php checked( get_option( 'kbe_sidebar_inner', 0 ), 0 ); ?>>
                                        <span><?php _e( 'None', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Knowledgebase comments', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_comments_setting" id="kbe_comment_setting" value="1" <?php checked( get_option( 'kbe_comments_setting', 0 ), '1' ); ?>>
                                        <span><?php _e( 'On', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_comments_setting" id="kbe_comment_setting" value="0" <?php checked( get_option( 'kbe_comments_setting', 0 ), '0' ); ?>>
                                        <span><?php _e( 'Off', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Knowledgebase theme color', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td colspan="3">
                                        <input type="text" name="kbe_bgcolor" id="kbe_bgcolor" value="<?php echo esc_attr( get_option( 'kbe_bgcolor', '' ) ); ?>" class="cp-field">
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <label><?php _e( 'Wipe all data on uninstall', 'wp-knowledgebase' ); ?></label>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_wipe_uninstall" id="kbe_wipe_uninstall_on" value="1" <?php checked( get_option( 'kbe_wipe_uninstall', 0 ), '1' ); ?>>
                                        <span><?php _e( 'On', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <input type="radio" name="kbe_wipe_uninstall" id="kbe_wipe_uninstall_off" value="0" <?php checked( get_option( 'kbe_wipe_uninstall', 0 ), '0' ); ?>>
                                        <span><?php _e( 'Off', 'wp-knowledgebase' ); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php _e( 'Note:', 'wp-knowledgebase' ); ?></strong>
                                        <?php _e( 'This also includes all your articles and CANNOT be undone.', 'wp-knowledgebase' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right" style="border:0px; padding-top: 10px;">
                                        <input type="hidden" name="update" value="update" />
                                        <input type="submit" value="<?php _e( 'Save Changes', 'wp-knowledgebase' ); ?>" class="button button-primary" name="submit" id="submit">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

            <div class="kbe_admin_sidebar">
            <table cellpadding="0" class="widefat" border="0">
                <thead>
                    <th scope="col"><?php _e( 'Need Support?', 'wp-knowledgebase' ); ?></th>
                </thead>
                <tbody>
                    <tr>
                        <td style="border:0;">
                            <?php _e( 'Check out the', 'wp-knowledgebase' ); ?>
                            <a href="http://wordpress.org/plugins/wp-knowledgebase/faq" target="_blank"><?php _e('FAQs','wp-knowledgebase'); ?></a>
                            <?php _e( 'and', 'wp-knowledgebase' ); ?>
                            <a href="http://wordpress.org/support/plugin/wp-knowledgebase" target="_blank"><?php _e('Support Forums','wp-knowledgebase'); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>

        </div>
    </div>
</div>
*/
?>

<div class="wrap kbe-wrap kbe-wrap-settings">

    <form method="post" action="options.php">

        <?php settings_fields( 'kbe_settings' ); ?>

        <!-- Page Heading -->
        <h1 class="wp-heading-inline"><?php echo __( 'Settings', 'wp-knowledgebase' ); ?></h1>
        <hr class="wp-header-end" />

        <?php

            settings_errors( 'general' );

            global $wpdb;

            $tbl_posts = $wpdb->prefix . 'posts';

            if ( isset( $kbe_settings['update'] ) ) {

                $kbe_posts = $wpdb->get_results( "SELECT * FROM $tbl_posts WHERE post_content LIKE '%[kbe_knowledgebase]%' AND post_type = 'page'" );

                foreach ( $kbe_posts as $kbe_post ) {
                    $kbe_id   = $kbe_post->ID;
                    $kbe_slug = get_option( 'kbe_plugin_slug' );

                    $kbe_post_data = array(
                        'post_name' => $kbe_slug
                    );

                    $kbe_post_where = array(
                        'ID' => $kbe_id
                    );

                    $wpdb->update( $tbl_posts, $kbe_post_data, $kbe_post_where );
                }

                flush_rewrite_rules();

                ?><div class='updated' style='margin-top:10px;'>
                    <p><?php _e( 'Settings updated successfully', 'wp-knowledgebase' ); ?></p>
                </div><?php

                unset( $kbe_settings['update'] );
                update_option( 'kbe_settings', $kbe_settings );

            }

        ?>

        <div id="kbe-content-wrapper">

            <!-- Primary Content -->
            <div id="kbe-primary">

                <!-- Register website -->
                <?php if( kbe_add_ons_exist() ): ?>

                    <div class="kbe-card">

                        <div class="kbe-card-header">
                            <?php echo __( 'Register Website', 'wp-knowledgebase' ); ?>
                        </div>

                        <div class="kbe-card-inner">

                            <!-- License Key -->
                            <div class="kbe-field-wrapper kbe-field-wrapper-inline kbe-field-wrapper-license-key kbe-last">

                                <div class="kbe-field-label-wrapper">
                                    <label for="kbe-license-key">
                                        <?php echo __( 'License Key', 'wp-knowledgebase' ); ?>
                                    </label>
                                </div>

                                <div class="kbe-flex-wrapper">

                                    <input id="kbe-license-key" name="license_key" type="text" value="<?php echo esc_attr( get_option( 'kbe_license_key', '' ) ); ?>">
                                    <a id="kbe-register-license-key" class="kbe-button-secondary" href="#">
                                        <span class="kbe-register" <?php echo ( kbe_is_website_registered() ? 'style="display: none;"' : '' ); ?>><?php echo __( 'Register', 'wp-knowledgebase' ); ?></span>
                                        <span class="kbe-deregister" <?php echo ( ! kbe_is_website_registered() ? 'style="display: none;"' : '' ); ?>><?php echo __( 'Deregister', 'wp-knowledgebase' ); ?></span>
                                    </a>
                                    
                                </div>

                                <input id="kbe-is-website-registered" type="hidden" value="<?php echo ( kbe_is_website_registered() ? 'true' : 'false' ); ?>" />

                            </div><!-- / License Key -->

                        </div>

                    </div>

                <?php endif; ?>
                <!-- / Register website -->

                <!-- General Settings -->
                <div class="kbe-card">

                    <div class="kbe-card-header">
                        <?php echo __( 'General Settings', 'wp-knowledgebase' ); ?>
                    </div>

                    <div class="kbe-card-inner">

                        <!-- Knowledgebase Slug -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-knowledgebase-slug">
                                    <?php echo __( 'Knowledgebase Slug', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <input id="kbe-knowledgebase-slug" name="kbe_plugin_slug" type="text" value="<?php echo esc_attr( get_option( 'kbe_plugin_slug', 'knowledgebase' ) ); ?>">

                        </div><!-- / Knowledgebase Slug -->

                        <!-- Number of Articles -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-number-of-articles">
                                    <?php echo __( 'Number of Articles to Show', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <input id="kbe-number-of-articles" name="kbe_article_qty" type="number" value="<?php echo esc_attr( get_option( 'kbe_article_qty', 5 ) ); ?>">

                            <p class="description kbe-description">
                                <strong><?php echo __( 'Note:', 'wp-knowledgebase' ); ?></strong>
                                <?php echo __( 'Set the number of articles to show in each category on KB homepage', 'wp-knowledgebase' ); ?>
                            </p>

                        </div><!-- / Number of Articles -->

                        <!-- Knowledgebase Comments -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-knowledgebase-comments">
                                    <?php echo __( 'Knowledgebase Comments', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <div class="kbe-switch">

                                <input id="kbe-knowledgebase-comments" class="kbe-toggle kbe-toggle-round" name="kbe_comments_setting" type="checkbox" value="1" <?php checked( get_option( 'kbe_comments_setting', 0 ), '1' ); ?> />
                                <label for="kbe-knowledgebase-comments"></label>

                            </div>

                            <label for="kbe-knowledgebase-comments"><?php echo __( 'Enables comments for your knowledgebase articles.', 'wp-knowledgebase' ); ?></label>

                        </div><!-- / Knowledgebase Comments -->

                        <!-- Output CSS -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-output-css">
                                    <?php echo __( 'Output CSS', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <div class="kbe-switch">

                                <input id="kbe-output-css" class="kbe-toggle kbe-toggle-round" name="kbe_output_style" type="checkbox" value="1" <?php checked( get_option( 'kbe_output_style', 0 ), '1' ); ?> />
                                <label for="kbe-output-css"></label>

                            </div>

                            <label for="kbe-output-css"><?php echo __( "If enabled, the plugin's stylesheet will be used.", 'wp-knowledgebase' ); ?></label>

                        </div><!-- / Output CSS -->

                        <!-- Wipe all data on uninstall -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline kbe-last">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-uninstall-data">
                                    <?php echo __( 'Wipe All Data on Uninstall', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <div class="kbe-switch">

                                <input id="kbe-uninstall-data" class="kbe-toggle kbe-toggle-round" name="kbe_wipe_uninstall" type="checkbox" value="1" <?php checked( get_option( 'kbe_wipe_uninstall', 0 ), '1' ); ?> />
                                <label for="kbe-uninstall-data"></label>

                            </div>

                            <label for="kbe-uninstall-data"><?php echo __( 'If enabled, when deleting the plugin all its data will be removed.', 'wp-knowledgebase' ); ?></label>

                            <p class="description kbe-description">
                                <strong><?php echo __( 'Note:', 'wp-knowledgebase' ); ?></strong>
                                <?php echo __( 'This also includes all your articles and CANNOT be undone.', 'wp-knowledgebase' ); ?>
                            </p>

                        </div><!-- / Wipe all data on uninstall -->

                    </div>

                </div><!-- / General Settings -->

                <!-- Design -->
                <div class="kbe-card">

                    <div class="kbe-card-header">
                        <?php echo __( 'Knowledgebase Design', 'wp-knowledgebase' ); ?>
                    </div>

                    <div class="kbe-card-inner">

                        <!-- Knowledgebase Home Page Sidebar -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-homepage-sidebar">
                                    <?php echo __( 'Main Page Template', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>
                            
                            <select id="kbe-homepage-sidebar" name="kbe_sidebar_home" class="kbe-select2">
                                <option value="0" <?php echo selected( get_option( 'kbe_sidebar_home', 0 ), 0 ); ?>><?php echo __( 'Full width', 'wp-knowledgebase' ); ?></option>
                                <option value="1" <?php echo selected( get_option( 'kbe_sidebar_home', 0 ), 1 ); ?>><?php echo __( 'With left sidebar', 'wp-knowledgebase' ); ?></option>
                                <option value="2" <?php echo selected( get_option( 'kbe_sidebar_home', 0 ), 2 ); ?>><?php echo __( 'With right sidebar', 'wp-knowledgebase' ); ?></option>
                            </select>

                        </div><!-- / Knowledgebase Home Page Sidebar -->

                        <!-- Knowledgebase Inner Page Sidebar -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-inner-pages-sidebar">
                                    <?php echo __( 'Inner Pages Template', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>
                            
                            <select id="kbe-inner-pages-sidebar" name="kbe_sidebar_inner" class="kbe-select2">
                                <option value="0" <?php echo selected( get_option( 'kbe_sidebar_inner', 0 ), 0 ); ?>><?php echo __( 'Full width', 'wp-knowledgebase' ); ?></option>
                                <option value="1" <?php echo selected( get_option( 'kbe_sidebar_inner', 0 ), 1 ); ?>><?php echo __( 'With left sidebar', 'wp-knowledgebase' ); ?></option>
                                <option value="2" <?php echo selected( get_option( 'kbe_sidebar_inner', 0 ), 2 ); ?>><?php echo __( 'With right sidebar', 'wp-knowledgebase' ); ?></option>
                            </select>

                        </div><!-- / Knowledgebase Inner Page Sidebar -->

                        <!-- Knowledgebase Theme Color -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline kbe-last">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-knowledgebase-theme-color">
                                    <?php echo __( 'Theme Color', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <input type="text" name="kbe_bgcolor" id="kbe_bgcolor" value="<?php echo esc_attr( get_option( 'kbe_bgcolor', '' ) ); ?>" class="cp-field">

                        </div><!-- / Knowledgebase Theme Color -->

                    </div>

                </div><!-- / Design -->

                <!-- Search -->
                <div class="kbe-card">

                    <div class="kbe-card-header">
                        <?php echo __( 'Knowledgebase Search', 'wp-knowledgebase' ); ?>
                    </div>

                    <div class="kbe-card-inner">

                        <!-- Enable Knowledgebase Search -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-enable-knowledgebase-search">
                                    <?php echo __( 'Enable Search', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <div class="kbe-switch">

                                <input id="kbe-enable-knowledgebase-search" class="kbe-toggle kbe-toggle-round" name="kbe_search_setting" type="checkbox" value="1" <?php checked( get_option( 'kbe_search_setting', 0 ), '1' ); ?> />
                                <label for="kbe-enable-knowledgebase-search"></label>

                            </div>

                            <label for="kbe-enable-knowledgebase-search"><?php echo __( 'Enables live search across your knowledgebase.', 'wp-knowledgebase' ); ?></label>

                        </div><!-- / Enable Knowledgebase Search -->

                        <!-- Live Search Excerpt -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-search-excerpt">
                                    <?php echo __( 'Live Search Results Excerpt', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <div class="kbe-switch">

                                <input id="kbe-search-excerpt" class="kbe-toggle kbe-toggle-round" name="kbe_search_excerpt" type="checkbox" value="1" <?php checked( get_option( 'kbe_search_excerpt', 0 ), '1' ); ?> />
                                <label for="kbe-search-excerpt"></label>

                            </div>

                            <label for="kbe-search-excerpt"><?php echo __( 'Shows the article excerpt alongside the title in the search results drop-down.', 'wp-knowledgebase' ); ?></label>

                        </div><!-- / Live Search Excerpt -->

                        <!-- Search Field Placeholder -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-search-field-placeholder">
                                    <?php echo __( 'Search Field Placeholder', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <input id="kbe-search-field-placeholder" name="kbe_search_field_placeholder" type="text" value="<?php echo esc_attr( get_option( 'kbe_search_field_placeholder', '' ) ); ?>">

                        </div><!-- / Search Field Placeholder -->

                        <!-- Search No Results Message -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline kbe-last">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-search-no-results-message">
                                    <?php echo __( 'No Results Message', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <input id="kbe-search-no-results-message" name="kbe_search_no_results_message" type="text" value="<?php echo esc_attr( get_option( 'kbe_search_no_results_message', '' ) ); ?>">

                        </div><!-- / Search No Results Message -->

                    </div>

                </div><!-- / Search -->

                <!-- Breadcrumbs -->
                <div class="kbe-card">

                    <div class="kbe-card-header">
                        <?php echo __( 'Knowledgebase Breadcrumbs', 'wp-knowledgebase' ); ?>
                    </div>

                    <div class="kbe-card-inner">

                        <!-- Knowledgebase Breadcrumbs -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-knowledgebase-breadcrumbs">
                                    <?php echo __( 'Enable Breadcrumbs', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <div class="kbe-switch">

                                <input id="kbe-knowledgebase-breadcrumbs" class="kbe-toggle kbe-toggle-round" name="kbe_breadcrumbs_setting" type="checkbox" value="1" <?php checked( get_option( 'kbe_breadcrumbs_setting', 0 ), '1' ); ?> />
                                <label for="kbe-knowledgebase-breadcrumbs"></label>

                            </div>

                            <label for="kbe-knowledgebase-breadcrumbs"><?php echo __( 'Enables breadcrumbs for your knowledgebase.', 'wp-knowledgebase' ); ?></label>

                        </div><!-- / Knowledgebase Breadcrumbs -->

                        <!-- Breadcrumbs Separator -->
                        <div class="kbe-field-wrapper kbe-field-wrapper-inline kbe-last">

                            <div class="kbe-field-label-wrapper">
                                <label for="kbe-breadcrumbs-separator">
                                    <?php echo __( 'Breadcrumbs Items Separator', 'wp-knowledgebase' ); ?>
                                </label>
                            </div>

                            <input id="kbe-breadcrumbs-separator" name="kbe_breadcrumbs_separator" type="text" value="<?php echo esc_attr( get_option( 'kbe_breadcrumbs_separator', '/' ) ); ?>">

                        </div><!-- / Breadcrumbs Separator -->

                    </div>

                </div><!-- / Breadcrumbs -->

                <?php 

                    /**
                     * Hook to add extra cards if needed to the General Settings tab
                     *
                     */
                    do_action( 'kbe_view_settings_tab_general_bottom' );

                ?>

            </div><!-- / Primary -->

            <!-- Secondary -->
            <div id="kbe-secondary">

                <div class="kbe-card">

                    <div class="kbe-card-header">
                        <?php echo __( 'Need help?', 'wp-knowledgebase' ); ?>
                    </div>

                    <div class="kbe-card-inner">

                        <?php echo sprintf( __( "Are you having issues setting up WP Knowledgebase? We can help. Just open a %ssupport ticket%s and we'll get back to you shortly.", 'wp-knowledgebase' ), '<a href="https://usewpknowledgebase.com/contact/" target="_blank">', '</a>' ); ?>

                    </div>

                </div>

            </div><!-- / Secondary -->

        </div><!-- / Content Wrapper -->

        <!-- Save Settings Button -->
        <input type="submit" class="kbe-form-submit button-primary" value="<?php echo __( 'Save Settings', 'wp-knowledgebase' ); ?>" />

        <!-- Action and nonce -->
        <input type="hidden" name="update" value="update" />
        <?php wp_nonce_field( 'kbe_save_settings', 'kbe_token', false ); ?>

    </form>

</div>
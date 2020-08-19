<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
?>

<?php
    $message = '';
    if ( isset( $_POST['kbe_order_submit'] ) ) {
        kbe_parent_article_order_update();
    }

    $message = '';

    if ( isset( $_POST['kbe_article_submit'] ) ) {
        kbe_custom_article_order_update();
    }
?>

<?php /*
<div id="wpbody">
    <div id="wpbody-content">
        <div class="wrap">

            <h2><?php _e( 'Re-Order', 'wp-knowledgebase' ); ?></h2>

            <?php
				$message = '';
				if ( isset( $_POST['kbe_order_submit'] ) ) {
					kbe_parent_article_order_update();
				}

				$message = '';

				if ( isset( $_POST['kbe_article_submit'] ) ) {
					kbe_custom_article_order_update();
				}
			?>

            <div class="kbe_admin_left_bar">
                <!--=============== Re Order Categories ===============-->
                <div class="kbe_admin_left_content">
                    <div class="kbe_admin_left_heading">
                        <h3><?php _e( 'Category Order', 'wp-knowledgebase' ); ?></h3>
                    </div>
                    <div class="kbe_admin_body">
                        <form name="custom_order_form" method="post" action="">
                        <?php
							$kbe_parent_ID = 0;
							$kbe_args      = array(
								'orderby'    => 'terms_order',
								'order'      => 'ASC',
								'hide_empty' => false
							);
							$kbe_terms     = get_terms( 'kbe_taxonomy', $kbe_args );
							if ( $kbe_terms ) {
						?>
                            <p><?php _e( 'Drag and drop items to customise the order of categories in WP Knowledgebase', 'wp-knowledgebase' ); ?></p>

                            <ul id="kbe_order_sortable" class="kbe_admin_order">
                            <?php
								foreach ( $kbe_terms as $kbe_term ) :
							?>
                                    <li id="kbe_parent_id_<?php echo $kbe_term->term_id; ?>" class="lineitem ui-state-default">
                                        <?php echo $kbe_term->name; ?>
                                    </li>
                            <?php
								endforeach;
							?>
                            </ul>
                            <input type="submit" name="kbe_order_submit" id="kbe_order_submit" class="button-primary" value="<?php _e( 'Save Order', 'wp-knowledgebase' ); ?>" />
                            <input type="hidden" id="kbe_parent_custom_order" name="kbe_parent_custom_order" />
                            <input type="hidden" id="kbe_parent_id" name="kbe_parent_id" value="<?php echo $kbe_parent_ID; ?>" />
                            <div class="spinner" id="kbe_custom_loading"></div>
                        <?php
							} else {
						?>
                            <p>
                                <?php _e( 'No terms found', 'wp-knowledgebase' ); ?>
                            </p>
                        <?php
							}
						?>
                        </form>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            //jQuery("#kbe_custom_loading").hide();
                            jQuery("#kbe_order_submit").click(function() {
                                kbeOrderSubmit();
                            });
                        });

                        function kbe_custome_order() {
                            //alert("hello 2");
                            jQuery("#kbe_order_sortable").sortable({
                                    placeholder: "sortable-placeholder",
                                    revert: false,
                                    tolerance: "pointer"
                            });
                        };

                        addLoadEvent(kbe_custome_order);
                        function kbeOrderSubmit() {
                            var kbeParentNewOrder = jQuery("#kbe_order_sortable").sortable("toArray");
                            //alert(kbeParentNewOrder);
                            //var newChildOrder = jQuery("#kbe_order_sortable").sortable("toArray");
                            jQuery("#kbe_custom_loading").css( 'opacity', 1 );
                            jQuery("#kbe_parent_custom_order").val(kbeParentNewOrder);
                            //jQuery("#hidden-custom-child-order").val(newChildOrder);
                            return true;
                        }

                    </script>
                </div>

                <!--=============== Re Order Articles ===============-->
                <div class="kbe_admin_left_content">
                    <div class="kbe_admin_left_heading">
                        <h3><?php _e( 'Article Order', 'wp-knowledgebase' ); ?></h3>
                    </div>
                    <div class="kbe_admin_body">
                        <form name="custom_order_form" method="post" action="">
                        <?php
							$kbe_article_args = new WP_Query( array(
														'post_type' => 'kbe_knowledgebase',
														'order'     => 'ASC',
														'orderby'   => 'menu_order',
														'nopaging'  => true,
													) );
							if ( $kbe_article_args->have_posts() ) {
						?>
                            <p><?php _e( 'Drag and drop items to customise the order of articles in WP Knowledgebase', 'wp-knowledgebase' ); ?></p>

                            <ul id="kbe_article_sortable" class="kbe_admin_order">
                            <?php $i = 1;
								while ( $kbe_article_args->have_posts() ) :
									$kbe_article_args->the_post();
							?>
                                    <li id="kbe_article_id_<?php the_ID(); ?>" class="lineitem <?php echo ($i % 2 == 0 ? 'alternate ' : ''); ?>ui-state-default">
                                        <?php echo _draft_or_post_title(); ?>
                                    </li>
                            <?php $i++;
								endwhile;
							?>
                            </ul>
                            <input type="submit" name="kbe_article_submit" id="kbe_article_submit" class="button-primary" value="<?php _e( 'Save Order', 'wp-knowledgebase' ); ?>" />
                            <input type="hidden" id="kbe_article_custom_order" name="kbe_article_custom_order" />
                            <div class="spinner" id="kbe_custom_loading_article"></div>
                        <?php
							} else {
						?>
                            <p>
                                <?php _e( 'No Articles found', 'wp-knowledgebase' ); ?>
                            </p>
                        <?php
							}
						?>
                        </form>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#kbe_article_submit").click(function() {
                                kbeArticleSubmit();
                            });
                        });

                        function kbe_custome_order_article() {
                            //alert("hello 2");
                            jQuery("#kbe_article_sortable").sortable({
                                    placeholder: "sortable-placeholder",
                                    revert: false,
                                    tolerance: "pointer"
                            });
                        };

                        addLoadEvent(kbe_custome_order_article);
                        function kbeArticleSubmit() {
                            var kbeArticleNewOrder = jQuery("#kbe_article_sortable").sortable("toArray");
                            jQuery("#kbe_custom_loading_article").css( 'opacity', 1 );
                            jQuery("#kbe_article_custom_order").val(kbeArticleNewOrder);
                            return true;
                        }

                    </script>
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
                            <a href="http://enigmaplugins.com/documentation/" target="_blank"><?php _e('FAQs','wp-knowledgebase'); ?></a>
                            <?php _e( 'and', 'wp-knowledgebase' ); ?>
                            <a href="http://wordpress.org/support/plugin/wp_knowledgebase" target="_blank"><?php _e('Support Forums','wp-knowledgebase'); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>

            <?php
				// Update Category Query
				function kbe_parent_article_order_update() {
					if ( isset( $_POST['kbe_parent_custom_order'] ) && $_POST['kbe_parent_custom_order'] != '' ) {

						global $wpdb;

						$parent_new_order = $_POST['kbe_parent_custom_order'];
						//echo $parent_new_order.'<br />';
						$parent_IDs       = explode( ',', $parent_new_order );
						//print_r($parent_IDs).'<br />';
						$parent_result    = count( $parent_IDs );
						for ( $p = 0; $p < $parent_result; $p++ ) {
							$parent_str  = str_replace( 'kbe_parent_id_', '', $parent_IDs[ $p ] );
							//echo $parent_str."<br />";
							$term_update = $wpdb->update( $wpdb->terms, array( 'terms_order' => $p ), array( 'term_id' => $parent_str ) );
						}
						echo '<div id="message" class="updated fade"><p>' . __( 'Category Order updated successfully.', 'wp-knowledgebase' ) . '</p></div>';
					} else {
						echo '<div id="message" class="error fade"><p>' . __( 'An error occured, order has not been saved.', 'wp-knowledgebase' ) . '</p></div>';
					}
				}

				// Update Articles Query
				function kbe_custom_article_order_update() {
					if ( isset( $_POST['kbe_article_custom_order'] ) && $_POST['kbe_article_custom_order'] != '' ) {
						global $wpdb;

						$article_new_order = $_POST['kbe_article_custom_order'];
						//echo $article_new_order.'<br />';
						$article_IDs       = explode( ',', $article_new_order );
						//print_r($article_IDs).'<br />';
						$article_result    = count( $article_IDs );

						for ( $a = 0; $a < $article_result; $a++ ) {
							$article_str    = str_replace( 'kbe_article_id_', '', $article_IDs[ $a ] );
							//echo $article_str."<br />";
							$article_update = $wpdb->update( $wpdb->posts, array( 'menu_order' => $a ), array( 'ID' => $article_str ) );
						}
						echo '<div id="message" class="updated fade"><p>' . __( 'Article Order updated successfully.', 'wp-knowledgebase' ) . '</p></div>';
					} else {
						echo '<div id="message" class="error fade"><p>' . __( 'An error occured, order has not been saved.', 'wp-knowledgebase' ) . '</p></div>';
					}
				}

			?>

	    </div>
    </div>
</div>
*/ 
?>

<div class="wrap kbe-wrap kbe-wrap-order">

    <!-- Page Heading -->
    <h1 class="wp-heading-inline"><?php echo __( 'Order Items', 'wp-knowledgebase' ); ?></h1>
    <hr class="wp-header-end" />

    <div id="kbe-content-wrapper">

        <!-- Primary Content -->
        <div id="kbe-primary">

            <!-- Category Order -->
            <div class="kbe-card">

                <div class="kbe-card-header">
                    <?php echo __( 'Category Order', 'wp-knowledgebase' ); ?>
                </div>

                <div class="kbe-card-inner">

                    <form name="custom_order_form" method="post" action="">
                        <?php
                            $kbe_parent_ID = 0;
                            $kbe_args      = array(
                                'orderby'    => 'terms_order',
                                'order'      => 'ASC',
                                'hide_empty' => false
                            );
                            $kbe_terms     = get_terms( 'kbe_taxonomy', $kbe_args );
                            if ( $kbe_terms ) {
                        ?>
                            <p style="margin-top: 0;"><?php _e( 'Drag and drop items to customise the order of categories in WP Knowledgebase', 'wp-knowledgebase' ); ?></p>

                            <ul id="kbe_order_sortable" class="kbe_admin_order">
                            <?php
                                foreach ( $kbe_terms as $kbe_term ) :
                            ?>
                                    <li id="kbe_parent_id_<?php echo $kbe_term->term_id; ?>" class="lineitem ui-state-default">
                                        <?php echo $kbe_term->name; ?>
                                    </li>
                            <?php
                                endforeach;
                            ?>
                            </ul>
                            <input type="submit" name="kbe_order_submit" id="kbe_order_submit" class="button-primary" value="<?php _e( 'Save Order', 'wp-knowledgebase' ); ?>" />
                            <input type="hidden" id="kbe_parent_custom_order" name="kbe_parent_custom_order" />
                            <input type="hidden" id="kbe_parent_id" name="kbe_parent_id" value="<?php echo $kbe_parent_ID; ?>" />
                            <div class="spinner" id="kbe_custom_loading"></div>
                        <?php
                            } else {
                        ?>
                            <p>
                                <?php _e( 'No terms found', 'wp-knowledgebase' ); ?>
                            </p>
                        <?php
                            }
                        ?>
                    </form>

                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            //jQuery("#kbe_custom_loading").hide();
                            jQuery("#kbe_order_submit").click(function() {
                                kbeOrderSubmit();
                            });
                        });

                        function kbe_custome_order() {
                            //alert("hello 2");
                            jQuery("#kbe_order_sortable").sortable({
                                    placeholder: "sortable-placeholder",
                                    revert: false,
                                    tolerance: "pointer"
                            });
                        };

                        addLoadEvent(kbe_custome_order);
                        function kbeOrderSubmit() {
                            var kbeParentNewOrder = jQuery("#kbe_order_sortable").sortable("toArray");
                            //alert(kbeParentNewOrder);
                            //var newChildOrder = jQuery("#kbe_order_sortable").sortable("toArray");
                            jQuery("#kbe_custom_loading").css( 'opacity', 1 );
                            jQuery("#kbe_parent_custom_order").val(kbeParentNewOrder);
                            //jQuery("#hidden-custom-child-order").val(newChildOrder);
                            return true;
                        }

                    </script>

                </div>

            </div><!-- / Category Order -->

            <!-- Article Order -->
            <div class="kbe-card">

                <div class="kbe-card-header">
                    <?php echo __( 'Article Order', 'wp-knowledgebase' ); ?>
                </div>

                <div class="kbe-card-inner">

                    <form name="custom_order_form" method="post" action="">
                        <?php
                            $kbe_article_args = new WP_Query( array(
                                                        'post_type' => 'kbe_knowledgebase',
                                                        'order'     => 'ASC',
                                                        'orderby'   => 'menu_order',
                                                        'nopaging'  => true,
                                                    ) );
                            if ( $kbe_article_args->have_posts() ) {
                        ?>
                            <p style="margin-top: 0;"><?php _e( 'Drag and drop items to customise the order of articles in WP Knowledgebase', 'wp-knowledgebase' ); ?></p>

                            <ul id="kbe_article_sortable" class="kbe_admin_order">
                            <?php $i = 1;
                                while ( $kbe_article_args->have_posts() ) :
                                    $kbe_article_args->the_post();
                            ?>
                                    <li id="kbe_article_id_<?php the_ID(); ?>" class="lineitem <?php echo ($i % 2 == 0 ? 'alternate ' : ''); ?>ui-state-default">
                                        <?php echo _draft_or_post_title(); ?>
                                    </li>
                            <?php $i++;
                                endwhile;
                            ?>
                            </ul>
                            <input type="submit" name="kbe_article_submit" id="kbe_article_submit" class="button-primary" value="<?php _e( 'Save Order', 'wp-knowledgebase' ); ?>" />
                            <input type="hidden" id="kbe_article_custom_order" name="kbe_article_custom_order" />
                            <div class="spinner" id="kbe_custom_loading_article"></div>
                        <?php
                            } else {
                        ?>
                            <p>
                                <?php _e( 'No Articles found', 'wp-knowledgebase' ); ?>
                            </p>
                        <?php
                            }
                        ?>
                    </form>

                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#kbe_article_submit").click(function() {
                                kbeArticleSubmit();
                            });
                        });

                        function kbe_custome_order_article() {
                            //alert("hello 2");
                            jQuery("#kbe_article_sortable").sortable({
                                    placeholder: "sortable-placeholder",
                                    revert: false,
                                    tolerance: "pointer"
                            });
                        };

                        addLoadEvent(kbe_custome_order_article);
                        function kbeArticleSubmit() {
                            var kbeArticleNewOrder = jQuery("#kbe_article_sortable").sortable("toArray");
                            jQuery("#kbe_custom_loading_article").css( 'opacity', 1 );
                            jQuery("#kbe_article_custom_order").val(kbeArticleNewOrder);
                            return true;
                        }

                    </script>

                </div>

            </div>
            <!-- / Article Order -->

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

    <?php
        /*====================>>_ Update Category Query _<<====================*/
        function kbe_parent_article_order_update() {
            if ( isset( $_POST['kbe_parent_custom_order'] ) && $_POST['kbe_parent_custom_order'] != '' ) {

                global $wpdb;

                $parent_new_order = $_POST['kbe_parent_custom_order'];
                //echo $parent_new_order.'<br />';
                $parent_IDs       = explode( ',', $parent_new_order );
                //print_r($parent_IDs).'<br />';
                $parent_result    = count( $parent_IDs );
                for ( $p = 0; $p < $parent_result; $p++ ) {
                    $parent_str  = str_replace( 'kbe_parent_id_', '', $parent_IDs[ $p ] );
                    //echo $parent_str."<br />";
                    $term_update = $wpdb->update( $wpdb->terms, array( 'terms_order' => $p ), array( 'term_id' => $parent_str ) );
                }
                echo '<div id="message" class="updated fade"><p>' . __( 'Category Order updated successfully.', 'wp-knowledgebase' ) . '</p></div>';
            } else {
                echo '<div id="message" class="error fade"><p>' . __( 'An error occured, order has not been saved.', 'wp-knowledgebase' ) . '</p></div>';
            }
        }

        /*====================>>_ Update Articles Query _<<====================*/
        function kbe_custom_article_order_update() {
            if ( isset( $_POST['kbe_article_custom_order'] ) && $_POST['kbe_article_custom_order'] != '' ) {
                global $wpdb;

                $article_new_order = $_POST['kbe_article_custom_order'];
                //echo $article_new_order.'<br />';
                $article_IDs       = explode( ',', $article_new_order );
                //print_r($article_IDs).'<br />';
                $article_result    = count( $article_IDs );

                for ( $a = 0; $a < $article_result; $a++ ) {
                    $article_str    = str_replace( 'kbe_article_id_', '', $article_IDs[ $a ] );
                    //echo $article_str."<br />";
                    $article_update = $wpdb->update( $wpdb->posts, array( 'menu_order' => $a ), array( 'ID' => $article_str ) );
                }
                echo '<div id="message" class="updated fade"><p>' . __( 'Article Order updated successfully.', 'wp-knowledgebase' ) . '</p></div>';
            } else {
                echo '<div id="message" class="error fade"><p>' . __( 'An error occured, order has not been saved.', 'wp-knowledgebase' ) . '</p></div>';
            }
        }

    ?>

</div>
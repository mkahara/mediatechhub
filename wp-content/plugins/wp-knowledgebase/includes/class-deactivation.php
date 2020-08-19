<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Handled the deactivation pop-up module
 *
 */
class KBE_Deactivation {

	/**
	 * Constructor
	 *
	 */
	public function __construct() {

		global $pagenow;

	    if( is_admin() && $pagenow == 'plugins.php' ) {

	    	add_action( 'admin_footer', array( $this, 'add_form' ) );
			add_action( 'admin_footer', array( $this, 'add_css' ) );
			add_action( 'admin_footer', array( $this, 'add_js' ) );

	    }

	    add_action( 'wp_ajax_kbe_send_deactivation_feedback', array( $this, 'send_feedback' ) );

	}


	/**
	 * Adds the deactivation modal fomr in the Plugins' page footer
	 *
	 */
	public function add_form() {

		?>

		<div id="kbe-deactivate-modal-wrapper">
		    <div id="kbe-deactivate-modal">
		    	<form action="" method="post">

		    		<!-- Modal header -->
		    		<div id="kbe-deactivate-header">
		    			<img src="<?php echo WP_KNOWLEDGEBASE; ?>/assets/images/kbe-logo.png" />
		    			<span>WP Knowledgebase</span>
		    		</div>

		    		<!-- Modal inner -->
		    		<div id="kbe-deactivate-inner">

			    	    <h3><?php echo __( "We're sorry to see you go", 'wp-knowledgebase' ); ?></h3>
			            <p><strong><?php echo __( 'Could you share with us the reason you are deactivating WP Knowledgebase?', 'wp-knowledgebase' ) ?></strong></p>

			    	    <ul>

			    	    	<li>
								<label>
									<input type="radio" name="kbe_disable_reason" value="technical-issue" />
									<strong><?php echo __( 'Technical issues', 'wp-knowledgebase' ); ?></strong>
									<p><?php echo sprintf( __( 'Please describe the issues below or %scontact us directly here%s. This will help us test and solve these problems in a timely manner.', 'wp-knowledgebase' ), '<a href="https://usewpknowledgebase.com/contact/" target="_blank">', '</a>' ); ?></p>
									<textarea name="kbe_disable_text[]" placeholder="<?php echo __( 'Type the issues here...', 'wp-knowledgebase' ); ?>"></textarea>
								</label>
							</li>

			                <li>
			                	<label>
			                		<input type="radio" name="kbe_disable_reason" value="missing-feature" />
			                		<strong><?php echo __( 'Missing features I need', 'wp-knowledgebase' ); ?></strong>
									<p><?php echo sprintf( __( 'Please describe the feature you need or %scontact us directly here%s. This will help us prioritize our tasks and work on the most requested features.', 'wp-knowledgebase' ), '<a href="https://usewpknowledgebase.com/contact/" target="_blank">', '</a>' ); ?></p>
									<textarea name="kbe_disable_text[]" placeholder="<?php echo __( 'Type the missing features here...', 'wp-knowledgebase' ); ?>"></textarea>
								</label>
							</li>

							<li>
								<label>
									<input type="radio" name="kbe_disable_reason" value="other" />
									<strong><?php echo __( 'Other reason', 'wp-knowledgebase' ); ?></strong>
			    			  		<p><?php echo __( 'We are continuously improving WP Knowledgebase and your feedback is extremely important to us. Please let us know how we can improve the plugin.', 'wp-knowledgebase' ); ?></p>
			    			  		<textarea name="kbe_disable_text[]" placeholder="<?php echo __( 'Type your feedback here...', 'wp-knowledgebase' ); ?>"></textarea>
			    			  	</label>
			    			</li>

			    	    </ul>

			    	</div>

			    	<!-- Modal footer -->
		    	    <div id="kbe-deactivate-footer">
			    	    <input disabled id="kbe-feedback-submit" class="button button-primary" type="submit" name="kbe-feedback-submit" value="<?php echo __( 'Submit & Deactivate', 'wp-knowledgebase' ); ?>" />
			    	    <a id="kbe-deactivate-close" href="#"><?php echo __( 'Do not deactivate', 'wp-knowledgebase'); ?></a>
			    	</div>

			    	<!-- Token -->
			    	<?php wp_nonce_field( 'kbe_deactivation', 'kbe_token', false ); ?>

		    	</form>
		    </div>
		</div>

		<?php

	}


	/**
	 * Adds the needed styles in the Plugins' page footer
	 *
	 */
	public function add_css() {

		?>

		<style>

			#kbe-deactivate-modal-wrapper { display: none; z-index: 9999; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,.35);  }
			#kbe-deactivate-modal { z-index: 10000; position: fixed; top: 7.5%; left: 50%; background: #fff; border-radius: 4px; max-width: 600px; margin-left: -300px; width: 100%; }
			
			#kbe-deactivate-header { padding: 20px 20px 15px 20px; border-bottom: 1px solid rgba( 200, 215, 225, 0.5 ); }
			#kbe-deactivate-header img { max-width: 35px; height: auto; vertical-align: middle; margin-right: 10px; }
			#kbe-deactivate-header span { display: inline-block; font-size: 18px; font-weight: bold; line-height: 35px; vertical-align: middle; }

			#kbe-deactivate-inner { padding: 20px; }

			#kbe-deactivate-inner > h3 { margin-top: 0; margin-bottom: 0; }
			#kbe-deactivate-inner > p { margin-top: 5px; margin-bottom: 20px; opacity: 0.8; }

			#kbe-deactivate-modal ul { margin: 0; }
			#kbe-deactivate-modal li { margin: 10px 0; transition: opacity 0.2s ease-in-out; }
			#kbe-deactivate-modal li label { display: block; padding: 15px; border-radius: 5px; background: rgba( 200, 215, 225, 0.2 ); }
			#kbe-deactivate-modal li:last-of-type { margin-bottom: 0; }
			#kbe-deactivate-modal li:hover { opacity: 1 !important; }
			#kbe-deactivate-modal li.kbe-inactive { opacity: 0.7; }

			#kbe-deactivate-modal ul p { display: none; margin: 5px 0 0 24px; opacity: 0.8; }

			#kbe-deactivate-modal textarea,
			#kbe-deactivate-modal input[type="text"] { display:none; width: 100%; }
			#kbe-deactivate-modal textarea { margin-left: 24px; margin-top: 10px; min-height: 65px; width: calc( 100% - 24px ); font-size: 13px; padding: 6px 11px; }
			#kbe-deactivate-modal #kbe-deactivate-close { float: right; line-height: 30px; }

			#kbe-deactivate-footer { border-top: 1px solid rgba( 200, 215, 225, 0.5 ); background: rgba( 200, 215, 225, 0.15 ); padding: 20px; }

		</style>

		<?php

	}


	/**
	 * Adds the needed JS in the Plugins' page footer
	 *
	 */
	public function add_js() {

		?>

		<script>

			jQuery( function($) {

				/**
				 * Show the deactivation modal when clicking the "Deactivate" link in the Plugins page
				 *
				 */
			    $(document).on( 'click', '.wp-admin.plugins-php tr[data-slug="wp-knowledgebase"] .row-actions .deactivate a', function(e) {

			        e.preventDefault();  
			        $('#kbe-deactivate-modal-wrapper').show();

			    });

			    /**
			     * Show/hide the description and feedback textarea for each list item when clicking on the
			     * corresponding radio input
			     *
			     */
			    $(document).on( 'click', '#kbe-deactivate-modal form input[type="radio"]', function () {

			        $(this).closest('ul').find( 'input[type="text"], textarea, p' ).hide();
			        
			        $(this).closest('ul').children('li').removeClass('kbe-inactive kbe-active');
			        $(this).closest('li').siblings('li').addClass( 'kbe-inactive' );
			        $(this).closest('li').addClass( 'kbe-active' );

			        $(this).closest('li').find( 'input[type="text"], textarea, p' ).show().focus();
			        
			        $('#kbe-feedback-submit').attr( 'disabled', false );

			    });

			    /**
			     * Hide the modal, make AJAX call to send feedback and then deactivate the plugin
			     *
			     */
			    $(document).on( 'click', '#kbe-feedback-submit', function(e) {

			        e.preventDefault();

			        $('#kbe-deactivate-modal-wrapper').hide();

			        $.ajax({
			            type 	 : 'POST',
			            url 	 : ajaxurl,
			            dataType : 'json',
			            data 	 : {
			                action 	  : 'kbe_send_deactivation_feedback',
			                kbe_token : $('#kbe_token').val(),
			                data   	  : $('#kbe-deactivate-modal form').serialize()
			            },
			            complete : function( MLHttpRequest, textStatus, errorThrown ) {

			                $('#kbe-deactivate-modal').remove();

			                window.location.href = $('.wp-admin.plugins-php tr[data-slug="wp-knowledgebase"] .row-actions .deactivate a').attr('href');   

			            }
			        });

			    });
			    
			    /**
			     * Hide the modal and do nothing else
			     *
			     */
			    $(document).on( 'click', '#kbe-deactivate-close', function(e) {

			        e.preventDefault();

			        $('#kbe-deactivate-modal-wrapper').hide();

			    });

			});

		</script>

		<?php

	}


	/**
	 * AJAX callback to send feedback to our email address
	 *
	 */
	public function send_feedback() {

		if( empty( $_POST['kbe_token'] ) || ! wp_verify_nonce( $_POST['kbe_token'], 'kbe_deactivation' ) )
			wp_die( 0 );

		// Exit if the user doesn't have priviledges
		if( ! current_user_can( 'manage_options' ) )
			wp_die( 0 );

		if( isset( $_POST['data'] ) ) {
	        parse_str( $_POST['data'], $form );
	    }
	    
	    $subject = "WP Knowledgebase Deactivation Notification";
	    $message = isset( $form['kbe_disable_reason'] ) ? 'Deactivation reason: ' . sanitize_text_field( $form['kbe_disable_reason'] ) : '(no reason given)';
	    
	    if( isset( $form['kbe_disable_text'] ) ) {
	        $message .= "\n\r\n\r";
	        $message .= 'Message: ' . sanitize_text_field( implode('', $form['kbe_disable_text']) );
	    }
	    
	    $success = wp_mail( array( 'support@slicewp.com' ), $subject, $message );

	    wp_die();

	}

}

new KBE_Deactivation();
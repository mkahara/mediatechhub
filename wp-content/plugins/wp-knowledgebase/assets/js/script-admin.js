jQuery(document).ready( function($) {

	/**
     * Initialize Color Picker
     *
     */
    $('.cp-field').wpColorPicker();


    /**
     * Initialize jQuery select2
     *
     */
    if( $.fn.select2 ) {
        $('.kbe-select2').select2({
            minimumResultsForSearch : Infinity
        }).on('select2:open', function() {
            var container = $('.select2-container').last();
            container.addClass('kbe-select2-container');
        });
    }


    /**
     * Register and deregister customer website from our servers
     *
     */
    $(document).on( 'click', '#kbe-register-license-key', function(e) {

        e.preventDefault();

        if( $('#kbe-is-website-registered').length == 0 )
            return false;

        var action = ( $('#kbe-is-website-registered').val() == 'false' ? 'register' : 'deregister' );

        $button = $(this);

        // Exit if button is disabled
        if( $button.hasClass( 'kbe-disabled' ) )
            return false;

        // Exit if the license key field is empty
        if( $button.siblings( 'input[type="text"]' ).val() == '' ) {
            $button.siblings( 'input[type="text"]' ).focus();
            return false;
        }

        // Disable license key field
        $button.siblings( 'input[type="text"]' ).attr( 'disabled', 'true' );

        // Disable the button
        $button.addClass( 'kbe-disabled' );

        // Remove the label
        $button.find( 'span' ).hide();
        
        // Add a spinner
        if( $button.find( '.spinner' ).length == 0 )
            $button.append( '<div class="spinner"></div>' );

        // Prepare AJAX call data
        var data = {
            action      : 'kbe_action_ajax_' + action + '_website',
            kbe_token   : $('#kbe_token').val(),
            license_key : $('#kbe-license-key').val()
        }

        // Make AJAX call
        $.post( ajaxurl, data, function( response ) {

            // Remove API message
            $button.closest( '.kbe-field-wrapper' ).find( '.kbe-api-action-message' ).remove();

            // Re-enable the button
            $button.siblings( 'input[type="text"]' ).removeAttr( 'disabled' );

            // Re-enable the button
            $button.removeClass( 'kbe-disabled' );

            // Remove spinner
            $button.find( '.spinner' ).remove();
            
            if( response.success == false ) {

                if( action == 'register' )
                    $button.find( 'span.kbe-register' ).show();

                if( action == 'deregister' )
                    $button.find( 'span.kbe-deregister' ).show();

                $button.closest( '.kbe-field-wrapper' ).append( '<div class="kbe-api-action-message kbe-api-action-message-error">' + response.data.message + '</div>' );
                $button.closest( '.kbe-field-wrapper' ).find( '.kbe-api-action-message' ).fadeIn();

            } else {

                if( action == 'register' )
                    $button.find( 'span.kbe-deregister' ).show();

                if( action == 'deregister' )
                    $button.find( 'span.kbe-register' ).show();

                $button.closest( '.kbe-field-wrapper' ).append( '<div class="kbe-api-action-message kbe-api-action-message-success">' + response.data.message + '</div>' );
                $button.closest( '.kbe-field-wrapper' ).find( '.kbe-api-action-message' ).fadeIn();

                if( action == 'register' )
                    $('#kbe-is-website-registered').val( 'true' );

                if( action == 'deregister' )
                    $('#kbe-is-website-registered').val( 'false' );

                if( action == 'deregister' )
                    $button.siblings( 'input[type="text"]' ).val( '' );

            }

        });

    });

});
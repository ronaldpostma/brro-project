<?php
//
// ******************************************************************************************************************************************************************** Admin instructions WP backend
//
// Index of Functions
//
// Later
//
add_action( 'admin_footer', 'brro_admin_jquery_script' );
function brro_admin_jquery_script() {
    $screen = get_current_screen();
    if ( in_array( $screen->base, ['post', 'post-new'] ) ) {
        ?>
        <script type='text/javascript'>
        jQuery(function($) {
            // WP Admin functions
            //
            // Limit excerpt to 141 characters
            var maxLength = 141;
            var excerptText = $('#excerpt');
            $('textarea#excerpt + p').addClass('cust-excerpt').text('Wordt gebruikt als samenvatting en meta-beschrijving voor zoekmachines. Max ' + maxLength + ' karakters');
            excerptText.attr('maxlength', maxLength);
            excerptText.on('input', function() {
                var text = excerptText.val();
                if (text.length > maxLength) {
                    excerptText.val(text.substring(0, maxLength));
                }
                $('textarea#excerpt').on('input', function() {
                    var text = $(this).val();
                    $('textarea#excerpt + p').text('Wordt gebruikt als samenvatting en meta-beschrijving voor zoekmachines. Max ' + maxLength + ' karakters: ' + text.length + '/' + maxLength);
                });
            });
        });
        </script>
        <?php
    }
}
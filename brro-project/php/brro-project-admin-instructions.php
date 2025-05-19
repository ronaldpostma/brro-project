<?php
//
// ******************************************************************************************************************************************************************** Admin instructions WP backend
//
// Index of Functions
//
// Later
//
add_action( 'admin_footer', 'brro_admin_instructions_scripts_styles' );
function brro_admin_instructions_scripts_styles() {
    //
    //Insert script into post.php and post-new.php
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
    // Inline CSS everywhere
    ?>
    <style>
    /* General styling of instruction elements */
    #excerpt {height:8em!important;}
    .acf-field-message h2 {padding:0px!important;font-size:16px!important;font-weight:500!important;}
    
    /* Uitleg bij posts-table 'alle berichten' overzicht */
    .tablenav.top:before,
    /* Uitleg bij featured image */
    #postimagediv .inside:after,
    /* Uitleg bij samenvatting */
    textarea#excerpt + p,
    /* Uitleg bij native wordpress content editor */
    #wp-content-editor-tools:before,
    /* Uitleg bij titel edit */
    #titlewrap:after,
    /* ACF info blok */
    .acf-field-message {
        display: block;
        margin: 40px 12px 24px 12px!important;
        font-size: 13px;
        font-weight: 500;
        padding: 12px 26px!important;
        background-color: rgba(0, 125, 62, .07);
        border-radius: 30px;
    }

    /* 
     * Instruction simple content with :after 
    */

    /* Blog / single post */
    .post-type-post #postimagediv .inside:after {
        content: "Wordt getoond als beeld in de hero naast te titel, en in het berichtenoverzicht.";
    }
    /* Specific page */
    .post-id-22 #postimagediv .inside:after {
        content: "Wordt getoond als achtergrondafbeelding bij de 'iets' sectie";
    }
    /* Custom post */
    .post-type-custom-post #wp-content-editor-tools:before {
        content: "Omschrijving en details van het evenement onder de titel + afbeelding sectie."
    }
    </style>
    <?php
}
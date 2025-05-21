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
    ?>
    <script type='text/javascript'>
    jQuery(function($) {
        // Admin page type
        var body = $('body');
        var isSingle = body.hasClass('[class*="post-type-"]') && body.hasClass('post-new-php') || body.hasClass('post-php');
        var isRedirection = body.hasClass('tools_page_redirection');
        var isProfile = body.hasClass('user-edit-php') || body.hasClass('profile-php');
        if (isSingle || isRedirection) {
            var osWindow = $('<div>', {
                css: {
                    'position': 'fixed',
                    'top': '20%',
                    'left': '20%',
                    'width': '60%',
                    'height': '60%',
                    'background-color': '#fff',
                    'border': '1px solid #ccc',
                    'box-shadow': '0 0 10px rgba(0,0,0,0.5)',
                    'z-index': '1000'
                }
            });

            var topBar = $('<div>', {
                css: {
                    'background-color': '#f1f1f1',
                    'padding': '10px',
                    'cursor': 'move',
                    'border-bottom': '1px solid #ccc'
                }
            }).text('OS Window');

            osWindow.append(topBar);
            body.append(osWindow);
        }
        //
        // Limit excerpt to 141 characters
        if (isSingle) {
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
        }
        //
        // Insert video in redirection screen
        if (isRedirection) {

        }
        //
        // Modify the wp-admin profile page
        if (isProfile) {
            var emailRow = $('tr.user-email-wrap');
            if (emailRow.length) {
                var profileTable = emailRow.closest('table');
                profileTable.attr('id', 'profile-table-sites');
            } 
            var bioRow = $('tr.user-description-wrap');
            if (bioRow.length) {
                var bioTable = bioRow.closest('table');
                bioTable.addClass('profile-table-bio');
                bioTable.prev('h2').addClass('profile-table-bio');
            }
        }
    });
    </script>
    <?php
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
        font-size: 13px;
	    font-weight: 500;
	    background-color: rgba(0, 125, 62, .07);
    }

    /* 
     * Instruction simple content with :after 
    */
    
    /* Post explanations */
    /* All posts */

    /* Blog / single post */
    .post-type-post #postimagediv .inside:after {
        content: "Wordt getoond als beeld naast de titel, en in het berichtenoverzicht.";
    }
    /* Contact pagina */
    .post-id-368 #wp-content-editor-tools:before {
        content: "Dit is de tekst onder de titel(s) en na de lead intro tekst.";
    }
    /* Custom post */
    .post-type-custom-post #wp-content-editor-tools:before {
        content: "Omschrijving en details van het evenement onder de titel + afbeelding sectie."
    }
    </style>
    <?php
}
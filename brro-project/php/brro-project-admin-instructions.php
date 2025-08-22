<?php
//
// ******************************************************************************************************************************************************************** Admin instructions WP backend
//
// Index of Functions
//
add_action( 'admin_footer', 'brro_admin_instructions_scripts_styles' );
function brro_admin_instructions_scripts_styles() {
    //
    ?>
    <script type='text/javascript'>
    jQuery(function($) {
        //
        //
        // Admin page type
        var body = $('body');
        var isSingle = body.hasClass('[class*="post-type-"]') && body.hasClass('post-new-php') || body.hasClass('post-php');
        var isRedirection = body.hasClass('tools_page_redirection');
        var isProfile = body.hasClass('user-edit-php') || body.hasClass('profile-php');
        //
        // Limit excerpt to 141 characters
        if (isSingle) {
            var maxLength = 141; // Set the maximum length for the excerpt
            var excerptText = $('#excerpt'); // Get the excerpt textarea element
            var excerptInfo = 'Wordt gebruikt als samenvatting en meta-beschrijving voor zoekmachines. Max ' + maxLength + ' karakters';
            // Add a class and text to the paragraph following the excerpt textarea
            $('textarea#excerpt + p').addClass('cust-excerpt').text(excerptInfo);
            excerptText.attr('maxlength', maxLength); // Set the maxlength attribute for the excerpt textarea
            // Add an input event listener to the excerpt textarea
            excerptText.on('input', function() {
                var text = excerptText.val(); // Get the current value of the textarea
                // If the text length exceeds the maximum length, trim it
                if (text.length > maxLength) {
                    excerptText.val(text.substring(0, maxLength));
                }
                // Update the paragraph text with the current character count
                $('textarea#excerpt + p').text(excerptInfo + ': ' + text.length + '/' + maxLength);
            });
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
    
    /* Explanation for posts-table 'all posts' overview */
    .tablenav.top:before,
    /* Explanation for featured image */
    #postimagediv .inside:after,
    /* Explanation for summary */
    textarea#excerpt + p,
    /* Explanation for native WordPress content editor */
    #wp-content-editor-tools:before,
    /* Explanation for title edit */
    #titlewrap:after,
    /* ACF info block */
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
    /* Specific page */
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
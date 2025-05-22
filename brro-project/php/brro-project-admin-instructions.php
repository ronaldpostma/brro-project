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
        //
        //
        //
        // FROM NATUURTALENT HAARLEM AS A BACKUP
        //
        //
        //
        // Admin page type
        var body = $('body');
        var isSingle = body.hasClass('[class*="post-type-"]') && body.hasClass('post-new-php') || body.hasClass('post-php');
        var isRedirection = body.hasClass('tools_page_redirection');
        var isProfile = body.hasClass('user-edit-php') || body.hasClass('profile-php');
        if (isRedirection) {
            $('head').append('<link rel="stylesheet" href="https://use.typekit.net/vzo7tht.css">');
            body.append(
                $('<div id="brro-help-window">').append(
                    $('<div id="brro-help-topbar">').append(
                        $('<span>Documentatie</span>')
                    )
                ).append('<div class="content">')
            );
            $('#brro-help-window .content').html('<p>Check <a href="https://brro.nl/support" target="_blank">brro.nl/support</a> voor algemene documentatie over het gebruik van onze Wordpress websites.</p>');
            $('#brro-help-window').on('click', function() {
                if (!$(this).hasClass('open')) {
                    $(this).addClass('open');
                    $('#brro-help-topbar').append('<span class="close">sluiten</span>');
                }
            });
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#brro-help-window.open').length || $(event.target).is('#brro-help-topbar .close')) {
                    $('#brro-help-window').removeClass('open');
                    $('#brro-help-topbar .close').remove();
                }
            });
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
        //
        var video = $('<iframe width="640" height="360" style="margin:8px 0;border:0;" scrolling="no" src="https://go.screenpal.com/player/VIDEOID?width=640&height=360&ff=1&title=0" allowfullscreen="true"></iframe>');
        //
        // Insert video in redirection screen
        if (isRedirection) {
            $('#brro-help-window .content').prepend('<div class="video">Bekijk hier een korte video over hoe redirects werken:</div>');
            $('#brro-help-window .content .video').append(video);
            var videoId = 'cTho6GnQSaX';
            video.attr('src', video.attr('src').replace('VIDEOID', videoId));
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
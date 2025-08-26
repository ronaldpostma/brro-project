jQuery(function($) {
    /* ========================================
       WP ADMIN SCRIPTS
       * Editor limits and profile tweaks
       ======================================== */
    // Admin page type
    var body = $('body');
    var isSingle = body.hasClass('[class*="post-type-"]') && body.hasClass('post-new-php') || body.hasClass('post-php');
    var isProfile = body.hasClass('user-edit-php') || body.hasClass('profile-php');
    /* ============= limit excerpt to 141 characters =================== */
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
    /* ============= modify wp-admin profile page =================== */
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
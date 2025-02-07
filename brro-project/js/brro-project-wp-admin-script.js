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
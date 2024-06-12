jQuery(function($) {
    // WP Admin functions
    return;
    // Limit excerpt to 141 characters
    var maxLength = 141;
    var excerptText = $('#excerpt');
	excerptText.attr('maxlength', maxLength);
    excerptText.on('input', function() {
        var text = excerptText.val();
        if (text.length > maxLength) {
            excerptText.val(text.substring(0, maxLength));
        }
    });
});
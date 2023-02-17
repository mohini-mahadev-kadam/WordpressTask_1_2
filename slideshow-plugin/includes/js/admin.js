jQuery(document).ready(function($) {
    $('#my-plugin-image-upload-button').click(function() {
        var customUploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        customUploader.on('select', function() {
            var attachment = customUploader.state().get('selection').first().toJSON();
            $('#my-plugin-image-preview').html('<img src="' + attachment.url + '" />');
            $('#my-plugin-image-upload').val(attachment.url);
        });
        customUploader.open();
    });
});

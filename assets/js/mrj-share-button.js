jQuery(document).ready(function() {
    jQuery('.share').click(function() {
        event.preventDefault();
        var link = jQuery(this).attr('href');
        navigator.clipboard.writeText(link).then(function() {
            alert('Link copied to clipboard!');
        }).catch(function(error) {
            console.error('Error copying text: ', error);
        });
    });
});

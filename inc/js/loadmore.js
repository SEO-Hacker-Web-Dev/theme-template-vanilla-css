jQuery(document).on('click', '#loadmore-btn', function(e) {
    e.preventDefault();
    var $btn = jQuery(this);
    var paged = parseInt($btn.data('paged'), 10) + 1;
    var args = $btn.data('args');
    var nonce = $btn.data('nonce');
    var maxpage = parseInt($btn.data('maxpage'), 10);

    $btn.prop('disabled', true).text('Loading...');

    jQuery.ajax({
        url: typeof my_loadmore_params !== 'undefined' ? my_loadmore_params.ajaxurl : '',  // <-- use localized object
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'my_loadmore',
            nonce: nonce,
            paged: paged,
            args: JSON.stringify(args)
        },
        success: function(response) {
            if (response && response.html) {
                jQuery('#loadmore-list').append(response.html);
                if (response.has_more && paged < maxpage) {
                    $btn.data('paged', paged).prop('disabled', false).text('Load More');
                } else {
                    $btn.hide();
                }
            } else {
                $btn.hide();
            }
        },
        error: function() {
            $btn.prop('disabled', false).text('Load More');
        }
    });
});
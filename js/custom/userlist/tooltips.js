$(document).ready(function () {

    $('.charakter').tooltipster({
        content: 'Loading...',
        contentAsHTML: true,
        functionBefore: function (origin, continueTooltip) {
            continueTooltip();
            if (origin.data('ajax') !== 'cached') {
                $.ajax({
                    type: 'POST',
                    url: 'freunde/preview',
                    data: {
                        id: $(this).attr('id')
                    },
                    success: function (data) {
                        origin.tooltipster('content', data)
                                .data('ajax', 'cached');
                    }
                });
            }
        }
    });

});
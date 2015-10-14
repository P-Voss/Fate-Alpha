$(document).ready(function () {

    $('.skill').tooltipster({
        content: 'Loading...',
        contentAsHTML: true,
        functionBefore: function (origin, continueTooltip) {
            continueTooltip();
            if (origin.data('ajax') !== 'cached') {
                jQuery.ajax({
                    type: 'POST',
                    url: baseUrl + '/Shop/skill/preview',
                    data: {
                        id: jQuery(this).children('input').val()
                    },
                    success: function (data) {
                        json = JSON.parse(data);
                        origin.tooltipster('content', json.beschreibung)
                                .data('ajax', 'cached');
                    }
                });
            }
        }
    });

    $('.magie').tooltipster({
        content: 'Loading...',
        contentAsHTML: true,
        functionBefore: function (origin, continueTooltip) {
            continueTooltip();
            if (origin.data('ajax') !== 'cached') {
                jQuery.ajax({
                    type: 'POST',
                    url: baseUrl + '/Shop/magie/preview',
                    data: {
                        id: jQuery(this).children('input').val()
                    },
                    success: function (data) {
                        json = JSON.parse(data);
                        origin.tooltipster('content', json.beschreibung)
                                .data('ajax', 'cached');
                    }
                });
            }
        }
    });

});
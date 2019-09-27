jQuery(document).ready(function () {

    jQuery(document).on('click', '#navigation', function (e) {
        if (e.target.localName !== 'p' && e.target.localName !== 'div') {
            return
        }
        if (jQuery(this).width() === 180) {
            jQuery(this).animate({width: 20})
            jQuery('#navigation .full').hide()
            jQuery('#navigation .compact').show()
        } else {
            jQuery(this).animate({width: 180})
            jQuery('#navigation .full').show()
            jQuery('#navigation .compact').hide()
        }
    })

    jQuery(document).on('click', '#navigationrechts', function (e) {
        if (e.target.localName !== 'p' && e.target.localName !== 'div') {
            return
        }
        if (jQuery(this).width() === 180) {
            jQuery(this).animate({width: 20})
            jQuery('#navigationrechts .full').hide()
            jQuery('#navigationrechts .compact').show()
        } else {
            jQuery(this).animate({width: 180})
            jQuery('#navigationrechts .full').show()
            jQuery('#navigationrechts .compact').hide()
        }
    })

});
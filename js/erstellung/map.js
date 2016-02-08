$(document).ready(function () {
    showPlaces();
    function showPlaces() {
        var map = jQuery("#map");
        var overlay = jQuery("#overlay");
        jQuery(overlay).append("#map")
                .removeAttr('style')
                .width(map.width())
                .height(map.height());
        jQuery('.Stadtteil').attr('fill-opacity', '0');
        jQuery('.Stadtteil').attr('opacity', '0.4');
    }
    jQuery('.Stadtteil').hover(function () {
        jQuery(this).attr('fill', '#FFF');
        jQuery(this).attr('opacity', '0.6');
        jQuery(this).attr('fill-opacity', '0.6');
    });
    
    function unselectPlaces(elements){
        elements[0].classList.remove('Selected');
    }
    
    jQuery('.Stadtteil').mouseout(function () {
        if(!$("<b></b>").addClass($(this).attr('class')).hasClass('Selected')){
            jQuery(this).attr('fill-opacity', '0');
            jQuery('.Stadtteil').attr('opacity', '0.4');
        }
    });
    
    jQuery('.Stadtteil').click(function () {
        if(jQuery('.Selected').length > 0){
            unselectPlaces(jQuery('.Selected'));
        }
        this.classList.add('Selected');
        jQuery('#wohnort').val(jQuery(this).attr('id'));
        jQuery(this).attr('fill', '#bbb');
    });
    
    
    
    jQuery('.ort').tooltipster({
        content: 'Loading...',
        contentAsHTML: true,
        functionBefore: function (origin, continueTooltip) {
            continueTooltip();
            if (origin.data('ajax') !== 'cached') {
                jQuery.ajax({
                    type: 'POST',
                    url: baseUrl + '/erstellung/orte',
                    data: {
                        name: jQuery(this).attr('id')
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        origin.tooltipster('content',   
                            "<table style='width: 190px;'>\n\
                                <tr>\n\
                                    <td rowspan='5'>\n\
                                        <img src='" + baseUrl +"/images/Map/" + data.img + ".png' width='100' height='100'/>\n\
                                    <td>\n\
                                    <td colspan='2'>\n\
                                        <strong>" + data.Name + "\
                                        </strong>\n\
                                    </td>\n\
                                </tr>\n\
                            </table>\n\
                            <p>" + data.Beschreibung + "</p>")
                                .data('ajax', 'cached');
                    }
                });
            }
        }
    });
    
    
    jQuery('.Stadtteil').tooltipster({
        content: 'Loading...',
        contentAsHTML: true,
        functionBefore: function (origin, continueTooltip) {
            continueTooltip();
            if (origin.data('ajax') !== 'cached') {
                jQuery.ajax({
                    type: 'POST',
                    url: baseUrl + '/erstellung/stadtteile',
                    data: {
                        name: jQuery(this).attr('id')
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        origin.tooltipster('content',   
                            "<table style='width: 190px;'>\n\
                                <tr>\n\
                                    <td rowspan='5'>\n\
                                        <img src='" + baseUrl +"/images/Map/" + data.img + ".png' width='100' height='100'/>\n\
                                    <td>\n\
                                    <td colspan='2'>\n\
                                        <strong>" + data.name + "\
                                        </strong><br />(" + data.bewohner + " Spieler)\n\
                                    </td>\n\
                                </tr>\n\
                            </table>\n\
                            <p>" + data.beschreibung + "</p>")
                                .data('ajax', 'cached');
                    }
                });
            }
        }
    });
});
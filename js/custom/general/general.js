$(document).ready(function () {
    
    indicators();
    
    function indicators(){
        indicators = jQuery(".indicator");
        for (i = 0; i < indicators.length; i++){
            element = indicators[i];
            jQuery(element).text(
                jQuery(element)
                    .parent()
                    .parent()
                    .children(".subContent")
                    .get(0)
                    .scrollHeight  > 0 ? "+" : ""
            );
        }
    }
    
    jQuery("legend").on('click', function(){
        element = jQuery(this).parent().children(".subContent");
        if(element.length !== 0){
            indicator = jQuery(this).children(".indicator");
            if(element.height() > 0){
                element.animate({height: 0}, {duration: 400, queue: false});
            }else{
                element.animate({height: element.get(0).scrollHeight}, {duration: 400, queue: false});
            }

            if(element.get(0).scrollHeight > 0){
                indicator.text(element.height() === element.get(0).scrollHeight ? "+" : "-");
            }
        }
    });


    jQuery(".dismiss").on('click', function () {
        var element = jQuery(this)
        jQuery.ajax({
            method: "POST",
            dataType: "json",
            url: baseUrl + "/Notification/index/remove",
            data: {
                id: element.data('id')
            },
            success: function (response) {
                jQuery(element).closest('.notification').remove()
                if (jQuery('.notification').length === 0) {
                    jQuery('#notifications').remove()
                }
            },
            error: function (error) {
            }
        })
    })
    
    jQuery(".imageSwitch").on("mouseover", function(){
//        jQuery("#charaktervalues").toggle();
//        jQuery("#startdata").prepend("<image id='activityImage' src='"+ baseUrl + "/images/activities/" + jQuery(this).attr("id") + ".png'/>");
//        jQuery("#activityImage").css({
//            "z-index": "-1",
//            "position": "absolute",
//            "opacity": "0.1"
//        });
    });
    
    jQuery(".imageSwitch").on("mouseout", function(){
//        jQuery("#activityImage").remove();
//        jQuery("#charaktervalues").toggle();
    });
    
});
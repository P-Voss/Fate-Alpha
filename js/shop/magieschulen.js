jQuery(document).ready(function () {
    
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

    jQuery('.school').on('click', function(){
        targetDiv = jQuery(this).parent().children('.subContent');
        if(targetDiv.html() !== ''){
            targetDiv.animate({
                height: "0"
            }, 400);
            targetDiv.html('');
            jQuery(this).html("Magien dieser Schule anzeigen");
        } else {
            displaySchule(targetDiv, jQuery(this).attr('data-id'));
        }
    });
    
    jQuery('#inhalt').on('click', '.magie',function(){
        htmlElement = jQuery(this).parents(".subContent");
        schulId = htmlElement.parent().children('legend').attr('data-id');
        jQuery.ajax({
            type: "POST",
            url: baseUrl + '/Shop/magie/unlock',
            data: {
                id: jQuery(this).attr('id')
            },
            success: function(data) {
                displaySchule(htmlElement, schulId);
            }
        });
    });

});

function displaySchule(element, id){
    jQuery.ajax({
        type: "POST",
        url: baseUrl + '/Shop/magie/show/id/' +id,
        data: {
            id: id
        },
        dataType: "json",
        success: function(data) {
            element.html(data.html);
            var fullHeight = element.css({'height': 'auto'}).height();
            element.css({'height': '0', "display": "block"});
            element.animate({
                height: fullHeight
            }, 1000);
        }
    });
    jQuery('.school[data-id=' + id + ']').html("Magien dieser Schule verbergen");
}
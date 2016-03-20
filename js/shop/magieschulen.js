jQuery(document).ready(function () {

    jQuery('.school').on('click', function(){
        targetDiv = jQuery(this).parent().children('.subContent');
        if(targetDiv.html() !== ''){
            targetDiv.animate({
                height: "0"
            }, 400);
            targetDiv.html('');
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
            var fullHeight = element.css({'height': 'auto', "display": "none"}).height();
            element.css({'height': '0', "display": "block"});
            element.animate({
                height: fullHeight
            }, 1000);
        }
    });
}
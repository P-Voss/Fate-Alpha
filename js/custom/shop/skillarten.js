jQuery(document).ready(function () {

    jQuery('.skillart').on('click', function(){
        targetDiv = jQuery(this).parent().children('.subContent');
        if(targetDiv.html() !== ''){
            targetDiv.animate({
                height: "0"
            }, 400);
            targetDiv.html('');
            jQuery(this).html("Fähigkeiten anzeigen");
        } else {
            displaySkillart(targetDiv, jQuery(this).attr('data-id'));
        }
    });
    
    jQuery('#inhalt').on('click', '.skill',function(){
        htmlElement = jQuery(this).parents(".subContent");
        skillartId = htmlElement.parent().children('legend').attr('data-id');
        jQuery.ajax({
            type: "POST",
            url: baseUrl + '/Shop/skill/unlock',
            data: {
                id: jQuery(this).attr('id')
            },
            success: function(data) {
                displaySkillart(htmlElement, skillartId);
            }
        });
    });

});

function displaySkillart(element, id){
    jQuery.ajax({
        type: "POST",
        url: baseUrl + '/Shop/skill/show/id/' +id,
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
    jQuery('.skillart[data-id=' + id + ']').html("Fähigkeiten verbergen");
}

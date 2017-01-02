
jQuery(document).ready(function () {
    
    jQuery('.information').on('click', function(){
        element = jQuery(this);
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/information/load",
            data: {
                id: element.attr('data-id'),
            },
            dataType: "json"
        })
        .success(function (response) {
            jQuery('#informationContent').html(response.html);
        });
    });
    
});
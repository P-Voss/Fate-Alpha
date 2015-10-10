jQuery(document).ready(function () {

    jQuery('.school').on('click', function(){
        id = this.id;
        jQuery('#dialog').attr('title', 'Upgrade your skillz, bitch');
        jQuery("#dialog").dialog({
            width: 1200,
            maxHeight: 700,
            closeOnEscape: true,
            draggable: false,
            modal: false,
            cache: false,
            position: {
                my: 'center',
                at: 'top+150'
            },
            open: function () {
                jQuery(this).load(baseUrl + '/Shop/skill/show/id/' + id);
            },
            close: function ()
            {
                
            }
        });
    });
    
    jQuery('#dialog').on('click', '.skill',function(){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + '/Shop/skill/unlock',
            data: {
                id: jQuery(this).attr('id')
            },
            success: function(data) {
                jQuery("#dialog").load(baseUrl + '/Shop/skill/show/id/' + id);
            }
        });
    });

});

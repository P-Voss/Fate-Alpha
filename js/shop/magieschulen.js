jQuery(document).ready(function () {

    jQuery('.school').on('click', function(){
        id = this.id;
        jQuery('#dialog').attr('title', 'Learn some magic, bro');
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
                jQuery(this).load(baseUrl + '/Shop/magie/show/id/' + id);
            },
            close: function ()
            {
                
            }
        });
    });
    
    jQuery('#dialog').on('click', '.magie',function(){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + '/Shop/magie/unlock',
            data: {
                id: jQuery(this).attr('id')
            },
            success: function(data) {
                jQuery("#dialog").load(baseUrl + '/Shop/magie/show/id/' + id);
            }
        });
    });

});

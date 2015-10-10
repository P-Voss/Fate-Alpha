jQuery(document).ready(function () {
    
    jQuery('#pass').click(function(){
        jQuery("#dialog").dialog({
            height: 350,
            width: 720,
            open: function() {
                jQuery(this).load(baseUrl + "/freunde/pass/charakter/" + id);
            }
        });
    });
    
    
});
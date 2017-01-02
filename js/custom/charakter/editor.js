
jQuery(document).ready(function () {
    
    tinymce.init({
        language: "de",
        selector:'textarea',
        visualblocks_default_state: false
    });
    
    jQuery(".profil").on('submit', function(ev){
        ev.preventDefault();
        frm = jQuery(this);
        tinyMCE.get(jQuery(frm).children("textarea").attr("id")).save();
        jQuery.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function(){
                
            }
        });
    });
    
});

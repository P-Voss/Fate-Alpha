jQuery(document).ready(function () {
    jQuery('#password').click(function(){
        jQuery('#dialog').removeAttr("title");
        jQuery('#dialog').attr('title', 'Passwort ändern');
        jQuery("#dialog").dialog({
            height: 220,
            width: 450,
            closeOnEscape: true,
            modal: true,
            open: function() {
                jQuery(this).load(baseUrl + "/user/password");
            },
            close: function()
            {
                jQuery(this).dialog('destroy')
            }
        });
    });
    jQuery('#mail').click(function(){
        jQuery('#dialog').removeAttr("title");
        jQuery('#dialog').attr('title', 'Email-Adresse ändern');
        jQuery("#dialog").dialog({
            height: 160,
            width: 450,
            closeOnEscape: true,
            modal: true,
            open: function() {
                jQuery(this).load(baseUrl + "/user/mail");
            },
            close: function()
            {
                jQuery(this).dialog('destroy')
            }
        });
    });
    jQuery('#account').click(function(){
        jQuery('#dialog').removeAttr("title");
        jQuery('#dialog').attr('title', 'Account löschen');
        jQuery("#dialog").dialog({
            height: 190,
            width: 450,
            closeOnEscape: true,
            modal: true,
            open: function() {
                jQuery(this).load(baseUrl + "/user/account");
            },
            close: function()
            {
                jQuery(this).dialog('destroy')
            }
        });
    });
    jQuery('#charakter').click(function(){
        jQuery('#dialog').removeAttr("title");
        jQuery('#dialog').attr('title', 'Charakter löschen');
        jQuery("#dialog").dialog({
            height: 190,
            width: 450,
            closeOnEscape: true,
            modal: true,
            open: function() {
                jQuery(this).load(baseUrl + "/user/charakter");
            },
            close: function()
            {
                jQuery(this).dialog('destroy')
            }
        });
    });
});

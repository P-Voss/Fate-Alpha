

jQuery(document).ready(function () {
    
    jQuery('#filterExecute').on('click', function (){
        var magieschulen = new Array();
        jQuery('#magieschulen option:selected').each(function() {
            magieschulen.push(jQuery(this).val());
        });
        var gruppen = new Array();
        jQuery('#gruppen option:selected').each(function() {
            gruppen.push(jQuery(this).val());
        });
        var klassen = new Array();
        jQuery('#klassen option:selected').each(function() {
            klassen.push(jQuery(this).val());
        });
        jQuery.ajax({
            url: baseUrl + '/Administration/magie/filter',
            type: 'POST',
            data: {
                magieschulen: magieschulen,
                gruppen: gruppen,
                klassen: klassen
            },
            dataType: 'json'
        })
        .success(function(data) {
            if (data['success']) {
                jQuery('#list').html(data['html']);
            }
        });
    });
    
});



jQuery(document).ready(function () {
    
    jQuery('#filterExecute').on('click', function (){
        var skillarten = new Array();
        jQuery('#skillarten option:selected').each(function() {
            skillarten.push(jQuery(this).val());
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
            url: baseUrl + '/Administration/skill/filter',
            type: 'POST',
            data: {
                skillarten: skillarten,
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

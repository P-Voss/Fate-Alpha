jQuery(document).ready(function () {
    
    jQuery('#inhalt').on('change', '.days', function(){
        getTrainingPreview(jQuery(this).val(), jQuery(this).attr('name'));
    });
    
    jQuery('#inhalt').on('click', '.execute', function(){
        attribute = jQuery(this).attr('id');
        days = jQuery('.days[name="' + attribute + '"]').val();
        if(days !== undefined && days > 0){
            executeBonusTraining(days, attribute);
        }
    });
    
});

function getTrainingPreview(dayCount, attribute){
    jQuery.ajax({
            type: "POST",
            url: baseUrl + "/charakter/trainingpreview",
            data: {
                attribute: attribute,
                days: dayCount
            },
            dataType: "json"
        })
        .success(function (response) {
            if(response.success === true){
                switch (attribute){
                    case "staerke":
                        jQuery('#staerkeWertUpdated').html(response.wert);
                        jQuery('#staerkeKategorieUpdated').html(response.kategorie);
                        break;
                    case "agilitaet":
                        jQuery('#agilitaetWertUpdated').html(response.wert);
                        jQuery('#agilitaetKategorieUpdated').html(response.kategorie);
                        break;
                    case "ausdauer":
                        jQuery('#ausdauerWertUpdated').html(response.wert);
                        jQuery('#ausdauerKategorieUpdated').html(response.kategorie);
                        break;
                    case "kontrolle":
                        jQuery('#kontrolleWertUpdated').html(response.wert);
                        jQuery('#kontrolleKategorieUpdated').html(response.kategorie);
                        break;
                    case "disziplin":
                        jQuery('#disziplinWertUpdated').html(response.wert);
                        jQuery('#disziplinKategorieUpdated').html(response.kategorie);
                        break;
                }
            }
        });
}

function executeBonusTraining(dayCount, attribute){
    jQuery.ajax({
            type: "POST",
            url: baseUrl + "/charakter/bonustraining",
            data: {
                attribute: attribute,
                days: dayCount
            },
            dataType: "json"
        })
        .success(function (response) {
            if(jQuery('#trainingstage').html() - days <= 0){
                window.location.replace(baseUrl + "/charakter");
            }
            if(response.success === true){
                jQuery('#Training').html(response.html);
            }
        });
}

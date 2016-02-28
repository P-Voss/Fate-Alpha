$(document).ready(function () {

    jQuery('#inhalt').on('click', '.reset.active', function(){
        category = jQuery(this).parent().attr('id');
        switch (category){
            case 'person':
                clearKlasse();
                personalData();
                break;
            case 'klasse':
                clearEigenschaften();
                klasse();
                break;
            case 'eigenschaften':
                clearVorNachteile();
                eigenschaften();
                break;
            case 'vorNachteile':
                clearUnterklasse();
                vorNachteile();
                break;
            case 'unterklasse':
                unterklassen();
                break;
        }
    });

});

function clearKlasse(){
    jQuery.ajax({
        type: "POST",
        url: baseUrl + "/Erstellung/Charakter/remove",
        data: {
            attribute: 'klasse'
        },
        dataType: "json",
    })
    .success(function (msg) {

    });
}

function clearEigenschaften(){
    jQuery.ajax({
        type: "POST",
        url: baseUrl + "/Erstellung/Charakter/remove",
        data: {
            attribute: 'eigenschaften'
        },
        dataType: "json",
    })
    .success(function (msg) {

    });
}

function clearVorNachteile(){
    jQuery.ajax({
        type: "POST",
        url: baseUrl + "/Erstellung/Charakter/remove",
        data: {
            attribute: 'vornachteile'
        },
        dataType: "json",
    })
    .success(function (msg) {

    });
}

function clearUnterklasse(){
    jQuery.ajax({
        type: "POST",
        url: baseUrl + "/Erstellung/Charakter/remove",
        data: {
            attribute: 'unterklasse'
        },
        dataType: "json",
    })
    .success(function (msg) {

    });
}
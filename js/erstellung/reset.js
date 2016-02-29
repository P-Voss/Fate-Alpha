$(document).ready(function () {

    jQuery('#inhalt').on('click', '.reset.active', function(){
        category = jQuery(this).parent().attr('id');
        switch (category){
            case 'person':
                clearKlasse();
                personalData();
                break;
            case 'klasse':
                clearKlasse();
                clearEigenschaften();
                klasse();
                break;
            case 'eigenschaften':
                clearEigenschaften();
                clearVorNachteile();
                eigenschaften();
                break;
            case 'vorNachteile':
                clearVorNachteile();
                vorNachteile();
                break;
            case 'unterklasse':
                clearUnterklasse();
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
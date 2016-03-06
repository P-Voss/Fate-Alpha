
jQuery(document).ready(function () {
    
    personalData();
    setClannamen();
    setVorteile();
    setNachteile();
    
    jQuery("#inhalt").on('click', "#person .nextStep", function(event){
        event.preventDefault();
        sendCharakterData();
    });
    
    jQuery("#inhalt").on('click', "#klasse .nextStep", function(event){
        event.preventDefault();
        setKlasse();
    });
    
    jQuery("#inhalt").on('click', "#eigenschaften .nextStep", function(event){
        event.preventDefault();
        setEigenschaften();
    });
    
    jQuery("#inhalt").on('click', "#vorNachteile .nextStep", function(event){
        event.preventDefault();
        unterklassen();
    });
    
    jQuery("#inhalt").on('click', "#unterklasse .nextStep", function(event){
        if(jQuery(".choices.unterklasse.marked").length === 0 || erstellungspunkte < 0){
            event.preventDefault();
        }
    });
    
});

function reset(category){
    switch (category){
        case 'person':
            clearKlasse();
            break;
        case 'klasse':
            clearEigenschaften();
            break;
        case 'eigenschaften':
            clearVorNachteile();
            break;
        case 'vorNachteile':
            clearUnterklasse();
            break;
        case 'unterklasse':
            break;
    }
}

function personalData(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/Charakter/person",
        dataType: "json",
    })
    .success(function (msg) {
        jQuery("#person .subContent").html(msg.html);
        jQuery("#helpText").html(msg.helptext);
        
        jQuery("#klasse .subContent").html('');
        jQuery("#eigenschaften .subContent").html('');
        jQuery("#vorNachteile .subContent").html('');
        jQuery("#unterklasse .subContent").html('');
        jQuery("#klasse .reset.active").removeClass('active');
        jQuery("#eigenschaften .reset.active").removeClass('active');
        jQuery("#vorNachteile .reset.active").removeClass('active');
        jQuery("#unterklasse .reset.active").removeClass('active');

        jQuery('#geburtsdatum').datepicker({
            dateFormat: "dd.mm.yy",
            changeMonth: true,
            changeYear: true,
            maxDate: "-12y",
            minDate: "-90y",
            yearRange: "c-90:+0"
        });
        reset('person');
    });
}

function sendCharakterData(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/erstellung/person",
        dataType: "json",
        data: jQuery("#personalData").serializeArray(),
    })
    .success(function (msg){
        if(msg.success === true){
            klasse();
            jQuery("#person .subContent").html('');
        }
    });
}

function klasse(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/Charakter/klasse",
        dataType: "json",
    })
    .success(function (msg) {
        jQuery("#klasse .subContent").html(msg.html);
        jQuery("#klasse .reset").addClass('active');
        jQuery("#helpText").html(msg.helptext);
        
        jQuery("#eigenschaften .subContent").html('');
        jQuery("#vorNachteile .subContent").html('');
        jQuery("#unterklasse .subContent").html('');
        jQuery("#eigenschaften .reset.active").removeClass('active');
        jQuery("#vorNachteile .reset.active").removeClass('active');
        jQuery("#unterklasse .reset.active").removeClass('active');
        jQuery("#klasse .reset").removeClass('inactive');
        reset('klasse');
        odo = 0;
        circuit = 0;
        luck = 0;
        vorteile = 0;
        nachteile = 0;
        unterklasse = 0;
        jQuery("#Erstellungspunkte").html(erstellungspunkte);
        refreshInterface();
    });
}

function setKlasse(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/erstellung/klasse",
        dataType: "json",
        data: {
            klassenId: jQuery(".choices.klasse.marked").attr('data-id')
        }
    })
    .success(function (msg){
        if(msg.success === true){
            eigenschaften();
            jQuery("#klasse .subContent").html('');
        }
    });
}


function eigenschaften(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/Charakter/eigenschaften",
        dataType: "json",
    })
    .success(function (msg) {
        jQuery("#eigenschaften .subContent").html(msg.html);
        jQuery("#eigenschaften .reset").addClass('active');
        jQuery("#helpText").html(msg.helptext);
        
        jQuery("#vorNachteile .subContent").html('');
        jQuery("#unterklasse .subContent").html('');
        jQuery("#vorNachteile .reset.active").removeClass('active');
        jQuery("#unterklasse .reset.active").removeClass('active');
        jQuery("#eigenschaften .reset").removeClass('inactive');
        reset('eigenschaften');
        odo = 0;
        circuit = 0;
        luck = 0;
        vorteile = 0;
        nachteile = 0;
        unterklasse = 0;
        refreshInterface();
    });
}

function setEigenschaften(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/erstellung/eigenschaften",
        dataType: "json",
        data: {
            element: jQuery("#element").val(),
            odo: jQuery("#odo").val(),
            circuit: jQuery("#circuit").val(),
            luck: jQuery("#luck").val()
        },
    })
    .success(function (msg){
        if(msg.success === true){
            vorNachteile();
            jQuery("#eigenschaften .subContent").html('');
        }
    });
}


function vorNachteile(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/Charakter/vornachteile",
        dataType: "json",
    })
    .success(function (msg) {
        jQuery("#vorNachteile .subContent").html(msg.html);
        jQuery("#vorNachteile .reset").addClass('active');
        jQuery("#helpText").html(msg.helptext);
        vorteilCount = msg.vorteilCount;
        
        jQuery("#unterklasse .subContent").html('');
        jQuery("#unterklasse .reset.active").removeClass('active');
        jQuery("#vorNachteile .reset").removeClass('inactive');
        reset('vorNachteile');
    });
    vorteile = 0;
    nachteile = 0;
    unterklasse = 0;
    refreshInterface();
}

function setVorNachteile(){

}


function unterklassen(){
    jQuery("#vorNachteile .subContent").html('');
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/Charakter/unterklasse",
        dataType: "json",
    })
    .success(function (msg) {
        jQuery("#unterklasse .subContent").html(msg.html);
        jQuery("#unterklasse .reset").addClass('active');
        jQuery("#unterklasse .reset").removeClass('inactive');
        jQuery("#helpText").html(msg.helptext);
    });
    unterklasse = 0;
    refreshInterface();
}

function setUnterklasse(id){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/erstellung/unterklasse",
        dataType: "json",
        data: {
            id: id
        },
    })
    .success(function (msg){
        if(msg.success === true){
            
        }
    });
}


function setClannamen(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/information/clans",
        dataType: "json"
    })
    .success(function(msg){
        clanNamen = msg;
    });
}

function setVorteile(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/information/vorteile",
        dataType: "json"
    })
    .success(function(msg){
        vorteilData = msg;
    });
}

function setNachteile(){
    jQuery.ajax({
        type: "POST",
        cache: false,
        url: baseUrl + "/Erstellung/information/nachteile",
        dataType: "json"
    })
    .success(function(msg){
        nachteilData = msg;
    });
}
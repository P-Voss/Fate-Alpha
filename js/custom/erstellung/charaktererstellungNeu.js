
document.onreadystatechange = function () {
     if (document.readyState === "complete") {
 
        var personData = new Vue({
            el: "#personData",
            data: {
                firstname: "",
                lastname: "",
                gender: "",
                birthdate: "",
                eyecolor: "",
                size: "",
                sexuality: "",
                place: "",
                classType: {
                    id: "",
                    name: ""
                },
                subClass: {
                    id: "",
                    name: ""
                },
                advantages: [
                    {id: 1, name: "Hübsch"},
                    {id: 2, name: "Klug"}
                ],
                disadvantages: []
            }
        });
        
        
   }
 };

var erstellungspunkte = 30;
var vorteilCount = 3;
var nachteilCount = 2;

var odo = 0;
var circuit = 0;
var luck = 0;
var vorteile = 0;
var nachteile = 0;
var unterklasse = 0;

var clanNamen = new Array();
var vorteilData = new Array();
var nachteilData = new Array();

    $(document).ready(function () {
        $("#beschreibungLinks").hide();
        $("#Erstellungspunkte").html(erstellungspunkte);
        
        jQuery('#inhalt').on('click', '#chooseWohnort',function(){
            jQuery('#dialog').removeAttr("title");
            jQuery('#dialog').attr('title', 'Fuyuki');
            jQuery("#dialog").dialog({
                height: 680,
                width: 1400,
                closeOnEscape: true,
                modal: true,
                open: function() {
                    jQuery(this).load(baseUrl + "/Fuyuki/map");
                },
                close: function()
                {
                    jQuery(this).dialog('destroy');
                }
            });
        });
        
        
        jQuery("#inhalt").on('click', ".choices.klasse", function(){
            if(jQuery(".choices.klasse.marked").attr('data-id') === jQuery(this).attr('data-id')){
                jQuery(".choices.klasse.marked").removeClass('marked');
                jQuery("#klasse .beschreibung").html('');
            }else{
                jQuery(".choices.klasse.marked").removeClass('marked');
                jQuery(this).addClass('marked');
                getKlassenBeschreibung(jQuery(this).attr('data-id'));
            }
        });
        
        
        jQuery("#inhalt").on('click', ".choices.unterklasse", function(){
            element = jQuery(this);
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/Information/unterklasse",
                data: {
                    id: element.attr('data-id')
                },
                dataType: "json"
            })
            .success(function (msg) {
                jQuery("#unterklasse .beschreibung").html(msg.beschreibung);
        
                if(jQuery(".choices.unterklasse.marked").attr('data-id') === element.attr('data-id')){
                    jQuery(".choices.unterklasse.marked").removeClass('marked');
                    jQuery("#unterklasse .beschreibung").html('');
                    unterklasse = 0;
                    jQuery("#unterklasse.nextStep").attr('disabled', true);
                }else{
                    jQuery(".choices.unterklasse.marked").removeClass('marked');
                    element.addClass('marked');
                    unterklasse = parseInt(msg.points);
                    setUnterklasse(element.attr('data-id'));
                }
                refreshInterface();
            });
        });
        
        
        jQuery("#inhalt").on("click", ".choices.vorteil", function(){
            element = jQuery(this);
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/Information/vorteil",
                data: {
                    id: jQuery(this).attr('data-id')
                },
                dataType: "json"
            })
            .success(function (msg) {
                jQuery("#vorNachteile .beschreibungVorteil").html(msg.beschreibung);
                if(element.hasClass('marked')){
                    element.removeClass('marked');
                    enable(element.attr('data-id'), 'vorteil');
                    refreshDisable();
                    vorteile = vorteile - parseInt(msg.points);
                    removeVorteil(element.attr('data-id'));
                }else if(element.hasClass('active') && jQuery('.choices.vorteil.active.marked').length < vorteilCount){
                    addVorteil(element.attr('data-id'));
                    element.addClass('marked');
                    markdisabled(element.attr('data-id'), 'vorteil', 'disabled');
                    vorteile = vorteile + parseInt(msg.points);
                }
                refreshInterface();
            });
        });
        
        
        jQuery("#inhalt").on("mouseenter", ".choices.vorteil", function(){
            markdisabled(jQuery(this).attr('data-id'), 'vorteil', 'disabledPreview');
        });
        
        
        jQuery("#inhalt").on("click", ".choices.nachteil", function(){
            element = jQuery(this);
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/Information/nachteil",
                data: {
                    id: jQuery(this).attr('data-id')
                },
                dataType: "json"
            })
            .success(function (msg) {
                jQuery("#vorNachteile .beschreibungNachteil").html(msg.beschreibung);
                if(element.hasClass('marked')){
                    element.removeClass('marked');
                    enable(element.attr('data-id'), 'nachteil');
                    refreshDisable();
                    nachteile = nachteile + parseInt(msg.points);
                    removeNachteil(element.attr('data-id'));
                }else if(element.hasClass('active') && jQuery('.choices.nachteil.active.marked').length < nachteilCount){
                    addNachteil(element.attr('data-id'));
                    element.addClass('marked');
                    markdisabled(element.attr('data-id'), 'nachteil', 'disabled');
                    nachteile = nachteile - parseInt(msg.points);
                }
                refreshInterface();
            });
        });
        
        
        jQuery("#inhalt").on("mouseenter", ".choices.nachteil", function(){
            markdisabled(jQuery(this).attr('data-id'), 'nachteil', 'disabledPreview');
        });
        
        
        jQuery("#inhalt").on("mouseleave", ".choices", function(){
            jQuery(".disabledPreview").removeClass('disabledPreview');
        });
        
        
        jQuery("#inhalt").on('change', '#odo', function(){
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/Information/odo",
                data: {
                    id: jQuery("#odo").val()
                },
                dataType: "json"
            })
            .success(function (msg) {
                jQuery(".beschreibungOdo").html(msg.beschreibung + ' Odo');
                odo = msg.points;
                refreshInterface();
            });
        });
        
        
        jQuery("#inhalt").on('change', '#circuit', function(){
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/Information/circuit",
                data: {
                    id: jQuery("#circuit").val()
                },
                dataType: "json"
            })
            .success(function (msg) {
                jQuery(".beschreibungCircuit").html(msg.beschreibung);
                circuit = msg.points;
                refreshInterface();
            });
        });
        
        
        jQuery("#inhalt").on('change', '#luck', function(){
            jQuery.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/Information/luck",
                data: {
                    id: jQuery("#luck").val()
                },
                dataType: "json"
            })
            .success(function (msg) {
                jQuery(".beschreibungLuck").html(msg.beschreibung);
                luck = msg.points;
                refreshInterface();
            });
        });
        
        
        
        
        
        $("#inhalt").on('change', '#vorname', function () {
            val = $(this).val();
            jQuery(this).val(val.toUpperCaseWords());
        });

        $("#inhalt").on('change', '#nachname', function () {
            val = jQuery(this).val();
            error = false;
            jQuery.each(clanNamen, function(index, clanname){
                if(val.toLocaleLowerCase() === clanname.toLocaleLowerCase()){
                    error = true;
                }
            });
            if(error === false){
                jQuery('#nachnameError').html('');
                jQuery(this).val(val.toUpperCaseWords());
            }else{
                jQuery('#nachnameError').html('Dieser Nachname ist nicht erlaubt');
                jQuery(this).val('');
            }
        });
        
        $("#geburtsdatum").change(function () {
            wert = $(this).val();
            $("#Geburtsdatum").html('Geboren am: ' + wert);
        });
        $("#m").change(function () {
            wert = $(this).val();
            $("#Geschlecht").html('(' + wert + ')');
        });
        $("#w").change(function () {
            wert = $(this).val();
            $("#Geschlecht").html('(' + wert + ')');
        });
        $("#augenfarbe").change(function () {
            wert = $(this).val();
            $("#Augenfarbe").html('Augenfarbe: ' + wert);
        });
        $("#körpergröße").change(function () {
            wert = $(this).val();
            $("#Körpergröße").html('Körpergröße: ' + wert + 'cm');
        });
        $("#sexualität").change(function () {
            wert = $(this).val();
            $("#Sexualität").html('Sexualität: ' + wert);
        });
        $("#wohnort").change(function () {
            wert = $(this).val();
            $("#Wohnort").html('Wohnt im Stadtteil ' + wert);
        });
    });
    

        
    function getKlassenBeschreibung(klassenId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Information/klasse",
            data: {
                id: klassenId
            },
            dataType: "json"
        })
        .success(function (msg) {
            jQuery("#klasse .beschreibung").html(msg.beschreibung);
        });
    }

    function getUnterklassenBeschreibung(unterklassenId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Information/unterklasse",
            data: {
                id: unterklassenId
            },
            dataType: "json"
        })
        .success(function (msg) {
            jQuery("#unterklasse .beschreibung").html(msg.beschreibung);
        });
    }

    function getVorteilBeschreibung(vorteilId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Information/vorteil",
            data: {
                id: vorteilId
            },
            dataType: "json"
        })
        .success(function (msg) {
            jQuery("#vorNachteile .beschreibungVorteil").html(msg.beschreibung);
        });
    }
    
    function addVorteil(vorteilId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Erstellung/vorteil",
            data: {
                id: vorteilId
            },
            dataType: "json"
        })
        .success(function (msg) {
            
        });
    }
    
    function removeVorteil(vorteilId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Erstellung/unsetvorteil",
            data: {
                id: vorteilId
            },
            dataType: "json"
        })
        .success(function (msg) {
            
        });
    }

    function getNachteilBeschreibung(nachteilId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Information/nachteil",
            data: {
                id: nachteilId
            },
            dataType: "json"
        })
        .success(function (msg) {
            jQuery("#vorNachteile .beschreibungNachteil").html(msg.beschreibung);
        });
    }
    
    function addNachteil(nachteilId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Erstellung/nachteil",
            data: {
                id: nachteilId
            },
            dataType: "json"
        })
        .success(function (msg) {
            
        });
    }
    
    function removeNachteil(nachteilId){
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "/Erstellung/Erstellung/unsetnachteil",
            data: {
                id: nachteilId
            },
            dataType: "json"
        })
        .success(function (msg) {
            
        });
    }
    
    function markdisabled(id, type, klasse){
        if(type === 'vorteil'){
            jQuery.each(vorteilData, function(index, vorteil){
                if(index === id){
                    jQuery.each(vorteil.vorteile, function(index, id){
                        jQuery(".choices.vorteil[data-id="+ id +"]").addClass(klasse);
                        if(klasse === 'disabled'){
                            jQuery(".choices.vorteil[data-id="+ id +"]").removeClass('active');
                        }
                    });
                    jQuery.each(vorteil.nachteile, function(index, id){
                        jQuery(".choices.nachteil[data-id="+ id +"]").addClass(klasse);
                        if(klasse === 'disabled'){
                            jQuery(".choices.nachteil[data-id="+ id +"]").removeClass('active');
                        }
                    });
                }
            });
        }
        if(type === 'nachteil'){
            jQuery.each(nachteilData, function(index, nachteil){
                if(index === id){
                    jQuery.each(nachteil.vorteile, function(index, id){
                        jQuery(".choices.vorteil[data-id="+ id +"]").addClass(klasse);
                        if(klasse === 'disabled'){
                            jQuery(".choices.vorteil[data-id="+ id +"]").removeClass('active');
                        }
                    });
                    jQuery.each(nachteil.nachteile, function(index, id){
                        jQuery(".choices.nachteil[data-id="+ id +"]").addClass(klasse);
                        if(klasse === 'disabled'){
                            jQuery(".choices.nachteil[data-id="+ id +"]").removeClass('active');
                        }
                    });
                }
            });
        }
    }
    
    function enable(id, type){
        return jQuery.ajax({
            type: "POST",
            async: false,
            url: baseUrl + "/Erstellung/Information/incompatibilities",
            data: {
                id: id,
                type: type
            },
            dataType: "json"
        })
        .success(function (msg) {
            if(msg.success === true){
                jQuery.each(msg.vorteile, function(index, vorteil){
                    jQuery(".choices.vorteil[data-id="+ vorteil +"]").removeClass('disabled');
                    jQuery(".choices.vorteil[data-id="+ vorteil +"]").addClass('active');
                });
                jQuery.each(msg.nachteile, function(index, nachteil){
                    jQuery(".choices.nachteil[data-id="+ nachteil +"]").removeClass('disabled');
                    jQuery(".choices.nachteil[data-id="+ nachteil +"]").addClass('active');
                });
            }
        });
    }
    
    function refreshDisable(){
        jQuery.each(jQuery(".choices.vorteil.marked"), function(index, element){
            markdisabled(jQuery(element).attr('data-id'), 'vorteil', 'disabled');
        });
        jQuery.each(jQuery(".choices.nachteil.marked"), function(index, element){
            markdisabled(jQuery(element).attr('data-id'), 'nachteil', 'disabled');
        });
    }
    
    function refreshInterface(){
        erstellungspunkte = 30 - (parseInt(odo) + parseInt(luck) + parseInt(circuit) + vorteile + nachteile + unterklasse);
        jQuery("#Erstellungspunkte").html(erstellungspunkte);
    }
    
   String.prototype.toUpperCaseWords = function () {
    return this.replace(/\w+/g, function(a){ 
      return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
    })
  }
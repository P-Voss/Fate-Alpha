    $(document).ready(function () {
        var erstellungspunkte = 30;
        var vorteilCount = 3;
        var nachteilCount = 2;
        $("#beschreibungLinks").hide();
        $("#Erstellungspunkte").html(erstellungspunkte);
        
        jQuery('#chooseWohnort').click(function(){
            jQuery('#dialog').removeAttr("title");
            jQuery('#dialog').attr('title', 'Fuyuki');
            jQuery("#dialog").dialog({
                height: 680,
                width: 1400,
                closeOnEscape: true,
                modal: true,
                open: function() {
                    jQuery(this).load(baseUrl + "/charakter/map");
                },
                close: function()
                {
//                    jQuery(this).dialog('destroy');
                }
            });
        });

        $("#newchara").click(function () {
            if ($("#vorname").val().length < 1) {
                alert('Der Vorname sieht nicht richtig aus.');
                return false;
            }
            if ($("#nachname").val().length < 1) {
                alert('Der Nachname sieht nicht richtig aus.');
                return false;
            }
            if ($("#Geschlecht").html().length < 1) {
                alert('M or W?');
                return false;
            }
            if ($("#körpergröße").val() < 130 || $("#körpergröße").val() > 210) {
                alert('Wie groß genau ist der Charakter?');
                return false;
            }
            if ($("#geburtsdatum").val().length < 1) {
                alert('Age?');
                return false;
            }
            if ($("#augenfarbe").val().length < 1) {
                alert('Beautiful ...eyes... wait, what kind of color is that actually?');
                return false;
            }
            if ($("#sexualität").val().length < 1) {
                alert('Worauf steht dein Charakter denn so?');
                return false;
            }
            if ($("#wohnort").val().length < 1) {
                alert('Location?');
                return false;
            }
            if ($("#vorteile :selected").length > vorteilCount) {
                alert('Zu viele Vorteile ausgewählt.');
                return false;
            }
            if ($("#nachteile :selected").length > nachteilCount) {
                alert('Zu viele Nachteile ausgewählt.');
                return false;
            }
            if(erstellungspunkte < 0){
                alert('Du hast zu viele Erstellungspunkte verbraucht.');
                return false;
            }
            $("#nachname").removeAttr('disabled');
        });

        $("#vorname").change(function () {
            wert = $(this).val();
            $.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/namevalidation",
                data: {
                    type: 'Vorname',
                    value: wert
                }
            })
                .success(function (msg) {
                    var returnValue = $.parseJSON(msg);
                    if (returnValue.result.toLocaleLowerCase() === wert.toLocaleLowerCase()) {
                        $("#Vorname").html('Name: ' + returnValue.result);
                        $("#vorname").val(returnValue.result);
                    } else {
                        $("#vorname").val('');
                        $("#vorname").attr('placeholder', returnValue.result);
                        $("#Vorname").html('');
                    }
                });
            $("#beschreibungLinks").show(1500);
        });

        $("#nachname").change(function () {
            wert = $(this).val();
            $.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/namevalidation",
                data: {
                    type: 'Nachname',
                    value: wert
                }
            })
                .success(function (msg) {
                    var returnValue = $.parseJSON(msg);
                    if (returnValue.result.toLocaleLowerCase() === wert.toLocaleLowerCase()) {
                        $("#Nachname").html(returnValue.result);
                        $("#nachname").val(returnValue.result);
                    } else {
                        $("#nachname").val('');
                        $("#nachname").attr('placeholder', returnValue.result);
                        $("#Nachname").html('');
                    }
                });
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
            $("#Wohnort").html('Wohnt in ' + wert);
        });
        $("#geburtsdatum").datepicker({
            dateFormat: "dd.mm.yy",
            changeMonth: true,
            changeYear: true,
            maxDate: "-12y",
            minDate: "-90y",
            yearRange: "c-90:+0"
        });

        $("#klasse").change(function () {
            $.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/class",
                data: {
                    id: $(this).val()
                }
            })
                .success(function (msg) {
                    result = $.parseJSON(msg);
                    $("#circuit").removeAttr('disabled');
                    if(result.gruppe === 2){
                        vorteilCount = 4;
                    }else{
                        vorteilCount = 3;
                        if(jQuery("#vorteile :selected").length > vorteilCount){
                            elem = jQuery("#vorteile :selected").eq(3).prop('selected', false);
                            elem = jQuery("#vorteile :selected").eq(3).removeAttr('selected');
                            refreshInterface(jQuery("#vorteile").val(), 'vorteil');
                        }
                    }
                    if(result.gruppe !== 1){
                        $("#circuit").val(0);
                        $("#circuit").attr('disabled', true);
                    }
                    if(result.familienname !== null){
                        $("#nachname").val(result.familienname);
                        $("#Nachname").html(result.familienname);
                        $("#nachname").attr('readonly', true);
                    }else{
                        $("#nachname").removeAttr('readonly');
                    }
                });
            refreshInterface($("#circuit").val(), 'circuit');
            refreshInterface($(this).val(), 'klasse');
            refreshInterface(jQuery("#vorteile").val(), 'vorteil');
        });
        $("#odo").change(function () {
            refreshInterface($(this).val(), 'odo');
        });
        $("#circuit").change(function () {
            refreshInterface($(this).val(), 'circuit');
        });
        $("#luck").change(function () {
            refreshInterface($(this).val(), 'luck');
        });
        $("#element").change(function () {
            refreshInterface($(this).val(), 'element');
        });

        $("#vorteile").on("click", "option", function () {
            if (vorteilCount > $(this).siblings(":selected").length) {
                refreshInterface($(this).val(), 'vorteil');
            } else {
                $(this).removeAttr("selected");
            }
        });

        $("#nachteile").on("click", "option", function () {
            if (nachteilCount > $(this).siblings(":selected").length) {
                refreshInterface($(this).val(), 'nachteil');
            } else {
                $(this).removeAttr("selected");
            }
        });

        function refreshInterface(latestId, latestType) {
            $.ajax({
                type: "POST",
                url: baseUrl + "/Erstellung/info",
                data: {
                    vorteile: getSelectedVorteile(),
                    nachteile: getSelectedNachteile(),
                    klasse: $("#klasse").val(),
                    odo: $("#odo").val(),
                    luck: $("#luck").val(),
                    circuit: $("#circuit").val(),
                    element: $("#element").val(),
                    type: latestType,
                    id: latestId
                }
            })
                    .success(function (msg) {
                        result = $.parseJSON(msg);
                        setBeschreibung(result.beschreibung);
                        setPunkte(result.punkte);
                        $("#vorteile").html(result.forms.vorteile);
                        $("#nachteile").html(result.forms.nachteile);
                    });
        }

        function getSelectedVorteile() {
            var vorteile = [];
            vorteileSelected = $.makeArray($("#vorteile :selected"));
            $.each(vorteileSelected, function (id, value) {
                vorteile.push(value['value']);
            });
            return vorteile;
        }
        function getSelectedNachteile() {
            var nachteile = [];
            nachteileSelected = $.makeArray($("#nachteile :selected"));
            $.each(nachteileSelected, function (id, value) {
                nachteile.push(value['value']);
            });
            return nachteile;
        }

        function setBeschreibung(msg) {
            $('#Beschreibung').html(msg);
        }
        function setPunkte(msg) {
            $('#Erstellungspunkte').html(msg);
        }
    });
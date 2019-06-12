jQuery(document).ready(function () {

    jQuery('.unlockSchool').on('click', function (e) {
        e.preventDefault();
        var form = jQuery(this).parent('form');
        swal({
            title: 'Magieschule beitreten?',
            text: 'Falls du bereits einer anderen Magieschule beigetreten bist, verlässt du sie wieder. Gelernte Magien gehen nicht verloren.',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Jap!',
            cancelButtonText: 'Ne, lieber nicht!'
        }).then(function(answer) {
            if (answer.value) {
                form.submit();
            }
        })
    });

    indicators();

    function indicators() {
        indicators = jQuery(".indicator");
        for (i = 0; i < indicators.length; i++) {
            element = indicators[i];
            jQuery(element).text(
                    jQuery(element)
                    .parent()
                    .parent()
                    .children(".subContent")
                    .get(0)
                    .scrollHeight > 0 ? "+" : ""
                    );
        }
    }

    jQuery("legend").on('click', function () {
        element = jQuery(this).parent().children(".subContent");
        if (element.length !== 0) {
            indicator = jQuery(this).children(".indicator");
            if (element.height() > 0) {
                element.animate({height: 0}, {duration: 400, queue: false});
            } else {
                element.animate({height: element.get(0).scrollHeight}, {duration: 400, queue: false});
            }

            if (element.get(0).scrollHeight > 0) {
                indicator.text(element.height() === element.get(0).scrollHeight ? "+" : "-");
            }
        }
    });

    jQuery('.school').on('click', function () {
        targetDiv = jQuery(this).parent().children('.subContent');
        if (targetDiv.html() !== '') {
            targetDiv.animate({
                height: "0"
            }, 400);
            targetDiv.html('');
            jQuery(this).html("Magien dieser Schule anzeigen");
        } else {
            displaySchule(targetDiv, jQuery(this).attr('data-id'));
        }
    });

    jQuery('#inhalt').on('click', '.magie', function () {
        var htmlElement = jQuery(this).parents(".subContent");
        var schulId = htmlElement.parent().children('legend').attr('data-id');
        var magieId = jQuery(this).attr('id');
        swal({
            title: 'Magie wirklich lernen?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Klar!',
            cancelButtonText: 'Ne, doch nicht!'
        }).then(function(answer) {
            if (answer.value) {
                jQuery.ajax({
                    type: "POST",
                    url: baseUrl + '/Shop/magie/unlock',
                    data: {
                        id: magieId
                    },
                    success: function (data) {
                        displaySchule(htmlElement, schulId);
                    }
                });
            }
        })
    });

});

function displaySchule(element, id) {
    jQuery.ajax({
        type: "POST",
        url: baseUrl + '/Shop/magie/show/id/' + id,
        data: {
            id: id
        },
        dataType: "json",
        success: function (data) {
            element.html(data.html);
            resizeSchuleHtml(element, 1000);
        }
    });
    jQuery('.school[data-id=' + id + ']').html("Magien dieser Schule verbergen");
}

function resizeSchuleHtml(element, animationSpeed) {
    var fullHeight = element.css({'height': 'auto'}).height();
    element.animate({
        height: fullHeight
    }, animationSpeed);
}


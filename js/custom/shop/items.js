jQuery(document).ready(function () {


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

    jQuery('#inhalt').on('click', '.buy', function () {
        var element = jQuery(this)
        var container = jQuery(this).closest('.item')
        var subcontent = jQuery(this).closest('.subContent')
        var itemId = jQuery(this).data('id');
        swal({
            title: 'Gegenstand kaufen?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Gib her!',
            cancelButtonText: 'Ne, doch nicht!'
        }).then(function(answer) {
            if (answer.value) {
                jQuery.ajax({
                    type: "POST",
                    url: baseUrl + '/Shop/item/buy',
                    data: {
                        id: itemId
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {
                            container.remove()
                            var fullHeight = subcontent.css({'height': 'auto'}).height();
                            subcontent.animate({
                                height: fullHeight
                            }, 500);
                        } else {
                            swal({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Du konntest den Gegenstand nicht kaufen',
                            })
                        }
                    }
                });
            }
        })
    });

});

jQuery(document).ready(function () {

    jQuery('.unlockSchool').on('click', function (e) {
        e.preventDefault();
        var form = jQuery(this).parent('form');
        swal({
            title: 'Magieschule freischalten?',
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
    
    jQuery('#inhalt').on('click', '.magieHeader', function() {
        jQuery(this).parent().children('.magieDetails').toggle();
        resizeSchuleHtml(jQuery(this).parents('.subContent'), 0);
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
            var fullHeight = element.css({'height': 'auto'}).height();
            element.css({'height': '0', "display": "block"});
            element.animate({
                height: fullHeight
            }, 1000);
        }
    });
    jQuery('.school[data-id=' + id + ']').html("Magien dieser Schule verbergen");
}
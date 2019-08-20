
jQuery(document).ready(function () {

    if (jQuery('#trait_1').length > 0) {
        CKEDITOR.inline('trait_1');
    }

    if (jQuery('#trait_2').length > 0) {
        CKEDITOR.inline('trait_2');
    }

    if (jQuery('#trait_3').length > 0) {
        CKEDITOR.inline('trait_3');
    }

    if (jQuery('#trait_4').length > 0) {
        CKEDITOR.inline('trait_4');
    }

    if (jQuery('#trait_5').length > 0) {
        CKEDITOR.inline('trait_5');
    }

    CKEDITOR.inline('story');
    CKEDITOR.inline('private');
    CKEDITOR.inline('objectives');

});

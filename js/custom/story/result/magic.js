


jQuery(document).ready(function () {

    jQuery('#inhalt').on('click', '.saveMagic', function(){
        var characterId = getCharacterId(jQuery(this))
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        addMagicRequest(
            selected,
            characterId
        );
        jQuery('.results[data-id="' + jQuery(this).attr('data-id') + '"]').html('');
    });

    jQuery('#inhalt').on('click', '.removeMagic', function(){
        var characterId = getCharacterId(jQuery(this))
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        removeMagicRequest(
            selected,
            characterId
        );
        jQuery('.results[data-id="' + jQuery(this).attr('data-id') + '"]').html('');
    });

});

function getCharacterId (element) {
    return jQuery(element).closest('.character').attr('data-id')
}

function addMagicRequest(magicIds, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/magic/request',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'magicIds': magicIds,
            'requesttype': 'add'
        },
        success: function() {
            refreshResult(charakterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

function removeMagicRequest(magicIds, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/magic/request',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'magicIds': magicIds,
            'requesttype': 'remove'
        },
        success: function() {
            refreshResult(charakterId);
        },
        error: function() {
            console.log('error');
        }
    });
}



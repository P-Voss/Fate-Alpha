


jQuery(document).ready(function () {

    jQuery('#inhalt').on('click', '.saveItems', function(){
        var characterId = getCharacterId(jQuery(this))
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        addItemRequest(
            selected,
            characterId
        );
        jQuery('.results[data-id="' + characterId + '"]').html('');
    });

    jQuery('#inhalt').on('click', '.removeItems', function(){
        var characterId = getCharacterId(jQuery(this))
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        removeItemRequest(
            selected,
            characterId
        );
        jQuery('.results[data-id="' + characterId + '"]').html('');
    });

});

function getCharacterId (element) {
    return jQuery(element).closest('.character').attr('data-id')
}

function addItemRequest(itemIds, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/item/request',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'itemIds': itemIds,
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

function removeItemRequest(itemIds, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/item/request',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'itemIds': itemIds,
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



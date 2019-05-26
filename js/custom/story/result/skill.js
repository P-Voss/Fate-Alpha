

jQuery(document).ready(function () {

    jQuery('#inhalt').on('click', '.saveSkills', function(){
        var characterId = getCharacterId(jQuery(this))
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        addSkillRequest(
            selected,
            characterId
        );
        jQuery('.results[data-id="' + characterId + '"]').html('');
    });

    jQuery('#inhalt').on('click', '.removeSkills', function(){
        var characterId = getCharacterId(jQuery(this))
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        removeSkillRequest(
            selected,
            characterId
        );
        jQuery('.results[data-id="' + characterId + '"]').html('');
    });

});

function getCharacterId (element) {
    return jQuery(element).closest('.character').attr('data-id')
}

function addSkillRequest(skillIds, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/skill/request',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'skillIds': skillIds,
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

function removeSkillRequest(skillIds, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/skill/request',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'skillIds': skillIds,
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

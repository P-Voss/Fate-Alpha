
jQuery(document).ready(function () {

    jQuery("#inhalt").on("click", ".saveAchievement", function () {
        var id = getCharacterId(jQuery(this))
        var title = jQuery("#title_" + id).val()
        var description = tinymce.get("description_" + id).getContent()
        addAchievement(title, description, id)
    })

    jQuery("#inhalt").on("click", ".removeAchievement", function () {
        var id = jQuery(this).attr("data-id")
        var characterId = getCharacterId(jQuery(this))
        var episodeId = jQuery(this).attr("data-episodeId")
        removeAchievement(id, characterId, episodeId)
    })

})

function getCharacterId (element) {
    return jQuery(element).closest('.character').attr('data-id')
}


function addAchievement(title, description, characterId) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/achievement/addrequest',
        dataType: 'json',
        data: {
            'episode': jQuery('#auswertung').attr('data-id'),
            'characterId': characterId,
            'title': title,
            'description': description
        },
        success: function() {
            refreshResult(characterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

function removeAchievement(achievementId, characterId, episodeId) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/removerequest',
        dataType: 'json',
        data: {
            'achievementId': achievementId,
            'characterId': characterId,
            'episodeId': episodeId
        },
        success: function() {
            refreshResult(characterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

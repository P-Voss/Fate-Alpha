
jQuery(document).ready(function () {

    jQuery("#inhalt").on("click", ".saveAchievement", function () {
        var id = getCharacterId(jQuery(this))
        var title = jQuery("#title_" + id).val()
        var description = tinymce.get("description_" + id).getContent()
        addAchievement(title, description, id)
    })

    jQuery("#inhalt").on("click", ".removeExistingAchievement", function () {
        var characterId = getCharacterId(jQuery(this))
        var achievementIds = []
        jQuery('#removeAchievement option:selected').each(function () {
            achievementIds.push(jQuery(this).val())
        })
        addRemovalRequest(characterId, achievementIds)
    })

    jQuery("#inhalt").on("click", ".removeAchievementRequest", function () {
        var requestId = jQuery(this).attr("data-id")
        var characterId = getCharacterId(jQuery(this))
        removeAchievement(requestId, characterId, episodeId)
    })

})

function getCharacterId (element) {
    return jQuery(element).closest('.character').attr('data-id')
}

function addRemovalRequest(characterId, achievementIds) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/achievement/addremovalrequest',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': characterId,
            'achievementIds': achievementIds
        },
        success: function() {
            refreshResult(characterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

function addAchievement(title, description, characterId) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/achievement/addrequest',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
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

function removeAchievement(requestId, characterId, episodeId) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/achievement/removerequest',
        dataType: 'json',
        data: {
            'requestId': requestId,
            'characterId': characterId,
            'episodeId': jQuery('#auswertung').attr('data-id')
        },
        success: function() {
            refreshResult(characterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

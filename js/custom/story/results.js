
var urls = {
    addMasks: {
        achievement: baseUrl + '/Story/achievement/show',
        skill: baseUrl + '/Story/skill/show',
        magic: baseUrl + '/Story/magic/show',
        item: baseUrl + '/Story/item/show',
        injury: baseUrl + '/Story/injury/show',
    },
    removalMasks: {
        achievement: baseUrl + '/Story/achievement/removal',
        skill: baseUrl + '/Story/skill/removal',
        magic: baseUrl + '/Story/magic/removal',
        item: baseUrl + '/Story/item/removal',
        injury: baseUrl + '/Story/injury/removal',
    },
    comment: baseUrl + '/Story/result/comment',
    kills: baseUrl + '/Story/result/kills',
    attributes: baseUrl + '/Story/result/attributes',
}

function getCharacterId (element) {
    return jQuery(element).closest('.character').attr('data-id')
}

jQuery(document).ready(function () {
    
    jQuery('.add .magie').on('click', function(){
        displayMask(urls.addMasks.magic, getCharacterId(jQuery(this)));
    });
    
    jQuery('.add .skill').on('click', function(){
        displayMask(urls.addMasks.skill, getCharacterId(jQuery(this)));
    });
    
    jQuery('.add .injury').on('click', function(){
        displayMask(urls.addMasks.injury, getCharacterId(jQuery(this)));
    });
    
    jQuery('.add .item').on('click', function(){
        displayMask(urls.addMasks.item, getCharacterId(jQuery(this)));
    });
    
    jQuery('.add .achievement').on('click', function(){
        displayMask(urls.addMasks.achievement, getCharacterId(jQuery(this)));
    });
    
    jQuery('.remove .magie').on('click', function(){
        displayMask(urls.removalMasks.magic, getCharacterId(jQuery(this)));
    });
    
    jQuery('.remove .skill').on('click', function(){
        displayMask(urls.removalMasks.skill, getCharacterId(jQuery(this)));
    });
    
    jQuery('.remove .injury').on('click', function(){
        displayMask(urls.removalMasks.injury, getCharacterId(jQuery(this)));
    });
    
    jQuery('.remove .item').on('click', function(){
        displayMask(urls.removalMasks.item, getCharacterId(jQuery(this)));
    });
    
    jQuery('.remove .achievement').on('click', function(){
        displayMask(urls.removalMasks.achievement, getCharacterId(jQuery(this)));
    });

    jQuery('.attribute').on('click', function(){
        displayMask(urls.attributes, getCharacterId(jQuery(this)));
    });
    
    jQuery('.killer').on('click', function(){
        displayMask(urls.kills, getCharacterId(jQuery(this)));
    });
    
    jQuery('.comment').on('click', function(){
        displayMask(urls.comment, getCharacterId(jQuery(this)));
    });


    jQuery('.npcKills').on('change', function(){
        updateNpcKills(getCharacterId(jQuery(this)), jQuery(this).val());
    });
    
    jQuery('.died').on('change', function(){
        updateGotKilled(getCharacterId(jQuery(this)), jQuery(this).prop('checked'));
    });
    
    
    jQuery('#inhalt').on('click', '.saveKills', function(){
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        addCharakterKills(selected, getCharacterId(jQuery(this)));
        jQuery('.results[data-id="' + getCharacterId(jQuery(this)) + '"]').html('');
    });
    
    
    jQuery('#inhalt').on('click', '.saveComment', function(){
        var content = tinymce.get('comment' + getCharacterId(jQuery(this))).getContent();
        updateComment(getCharacterId(jQuery(this)), content);
        jQuery('.results[data-id="' + getCharacterId(jQuery(this)) + '"]').html('');
    });


});

function updateComment(charakterId, comment){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/setcomment',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'comment': comment,
        },
        success: function() {
            refreshResult(charakterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

function updateGotKilled(charakterId, gotKilled){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/death',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'gotKilled': gotKilled,
        },
        success: function() {
            refreshResult(charakterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

function updateNpcKills(charakterId, value){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/npc',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'killcount': value,
        },
        success: function() {
            refreshResult(charakterId);
        },
        error: function() {
            console.log('error');
        }
    });
}


function addCharakterKills(ids, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/kills',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
            'ids': ids
        },
        success: function() {
            refreshResult(charakterId);
        },
        error: function() {
            console.log('error');
        }
    });
}

function displayMask(url, characterId) {
    jQuery.ajax({
        type: 'Post',
        url: url,
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': characterId
        },
        success: function(data) {
            jQuery('.results[data-id="' + characterId + '"]').html(data['html']);
            initEditor();
        },
        error: function() {
            console.log('error');
        }
    });
}


function refreshResult(charakterId) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/refresh',
        dataType: 'json',
        data: {
            'episodeId': jQuery('#auswertung').attr('data-id'),
            'characterId': charakterId,
        },
        success: function(data) {
            jQuery('.zusammenfassung[data-id="' + charakterId + '"]').html(data['html']);
        },
        error: function() {
            console.log('error');
        }
    });
}

function initEditor(){
    tinymce.remove();
    tinymce.init({
        language: "de",
        selector:'textarea',
        visualblocks_default_state: false
    });
}
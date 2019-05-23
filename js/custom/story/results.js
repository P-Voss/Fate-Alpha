

jQuery(document).ready(function () {
    
    jQuery('.add .magie').on('click', function(){
        displayMask('magie', 'add', jQuery(this).attr('data-id'));
    });
    
    jQuery('.add .skill').on('click', function(){
        displayMask('skill', 'add', jQuery(this).attr('data-id'));
    });
    
    jQuery('.add .injury').on('click', function(){
        displayMask('injury', 'add', jQuery(this).attr('data-id'));
    });
    
    jQuery('.add .item').on('click', function(){
        displayMask('item', 'add', jQuery(this).attr('data-id'));
    });
    
    jQuery('.add .achievement').on('click', function(){
        displayMask('achievement', 'add', jQuery(this).attr('data-id'));
    });
    
    jQuery('.remove .magie').on('click', function(){
        displayMask('magie', 'removal', jQuery(this).attr('data-id'));
    });
    
    jQuery('.remove .skill').on('click', function(){
        displayMask('skill', 'removal', jQuery(this).attr('data-id'));
    });
    
    jQuery('.remove .injury').on('click', function(){
        displayMask('injury', 'removal', jQuery(this).attr('data-id'));
    });
    
    jQuery('.remove .item').on('click', function(){
        displayMask('item', 'removal', jQuery(this).attr('data-id'));
    });
    
    jQuery('.remove .achievement').on('click', function(){
        displayMask('achievement', 'removal', jQuery(this).attr('data-id'));
    });
    
    jQuery('.attribute').on('click', function(){
        displayMask('attribute', '', jQuery(this).attr('data-id'));
    });
    
    jQuery('.killer').on('click', function(){
        displayMask('killer', '', jQuery(this).attr('data-id'));
    });
    
    jQuery('.comment').on('click', function(){
        displayMask('comment', '', jQuery(this).attr('data-id'));
    });
    
    jQuery('.npcKills').on('change', function(){
        updateNpcKills(jQuery(this).attr('data-id'), jQuery(this).val());
    });
    
    jQuery('.died').on('change', function(){
        updateGotKilled(jQuery(this).attr('data-id'), jQuery(this).prop('checked'));
    });
    
    jQuery('#inhalt').on('click', '.save', function(){
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        addResultStats(
            jQuery(this).attr('data-art'),
            jQuery(this).attr('data-request'),
            selected,
            jQuery(this).attr('data-id')
        );
        jQuery('.results[data-id="' + jQuery(this).attr('data-id') + '"]').html('');
    });
    
    
    jQuery('#inhalt').on('click', '.saveKills', function(){
        var selected = [];
        jQuery(this).parent().find('select option:selected').each(function(){
            selected.push(jQuery(this).val());
        });
        addCharakterKills(selected, jQuery(this).attr('data-id'));
        jQuery('.results[data-id="' + jQuery(this).attr('data-id') + '"]').html('');
    });
    
    
    jQuery('#inhalt').on('click', '.saveComment', function(){
        var id = jQuery(this).attr('data-id');
        var content = tinymce.get('comment' + id).getContent();
        updateComment(id, content);
        jQuery('.results[data-id="' + id + '"]').html('');
    });

    jQuery('#inhalt').on('click', '.saveAchievement', function(){
        var id = jQuery(this).attr('data-id');
        var title = jQuery('#title' + id).val();
        console.log(id)
        var description = tinymce.get('description' + id).getContent();
        addAchievement(title, description, id);
    });

});

function updateComment(charakterId, comment){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/setcomment',
        dataType: 'json',
        data: {
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': charakterId,
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
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': charakterId,
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
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': charakterId,
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

function addResultStats(art, request, ids, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/request',
        dataType: 'json',
        data: {
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': charakterId,
            'requesttype': request,
            'art': art,
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

function addCharakterKills(ids, charakterId){
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/kills',
        dataType: 'json',
        data: {
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': charakterId,
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


function addAchievement(title, description, characterId) {
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/addachievement',
        dataType: 'json',
        data: {
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': characterId,
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


function displayMask(action, type, id) {
    if(type === 'removal'){
        action = 'remove' + action;
    }
    jQuery.ajax({
        type: 'Post',
        url: baseUrl + '/Story/result/' + action,
        dataType: 'json',
        data: {
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': id
        },
        success: function(data) {
            jQuery('.results[data-id="' + id + '"]').html(data['html']);
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
            'episode': jQuery('#auswertung').attr('data-id'),
            'charakterId': charakterId,
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
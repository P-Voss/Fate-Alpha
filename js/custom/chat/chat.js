
jQuery(document).ready(function(){
    
    jQuery('#message').autocomplete({
        source: users,
        minLength: 0,
        disabled: true
    });
    
    
    jQuery('#message').on('keyup', function(){
        var result = /^@([\w{1}][\w]*)$/.exec(jQuery('#message').val());
        var messageParts = jQuery('#message').val().split(" ");
        if (result !== null && messageParts.length === 1) {
            jQuery('#message').autocomplete("option", "disabled", false);
            jQuery('#message').autocomplete("option", "response", function(event, ui){
                if (ui.content[0] !== undefined) {
                    ui.content[0].value = "@" + ui.content[0].value;
                }
            });
            jQuery('#message').autocomplete("search", result[1]);
        } else {
            jQuery('#message').autocomplete("option", "disabled", true);
        }
    });
    
    jQuery("#toggleUser").on('click', function() {
        if (jQuery("#userList").css("display") === "none") {
            jQuery("#messages").animate({width: "86%"}, 200, "linear",
            function() {
                jQuery("#toggleUser").html("Verstecken");
                jQuery("#userList").slideToggle(200, "linear");
            });
        } else {
            jQuery("#userList").slideToggle(200, "linear", 
            function (){
                jQuery("#messages").animate({width: "100%"}, 200, "linear");
                jQuery("#toggleUser").html("Anzeigen");
            });
        }
    });

    jQuery("#send").on('click', function(event){
        jQuery('#message').autocomplete("option", "disabled", false);
        event.preventDefault();
        sendMessage();
        jQuery('#message').autocomplete("option", "disabled", true);
    });
    
    jQuery("#roomlist").on('change', function(){
        switchRoom(jQuery("#roomlist option:selected").val());
    });
    
    jQuery("#chat_form").on('submit', function(event){
        event.preventDefault();
        sendMessage();
    });
    
});

if (baseUrl === '') {
    var ws = new WebSocket("wss://fate-alpha.de:8181");
} else {
    var ws = new WebSocket("ws://192.168.178.31:8181");
}
var users = [];
ws.onopen = function (e) {
    ws.send("/init " + jQuery("#userId").val());
};

ws.onmessage = function (e) {
    var data = JSON.parse(e.data);
    if (data.type === "message") {
        displayMessage(data.name, data.message);
    }
    if (data.type === "disconnect") {
        displayMessage(data.name, data.message);
        ws.close();
    }
    if (data.type === "userlist") {
        refreshUserList(data.message);
    }
    if (data.type === "roomlist") {
        refreshRoomList(data.message);
    }
    if (data.type === "whisper") {
        displayMessage(data.name + " flüstert", data.message, "msg");
    }
    if (data.type === "whisperAcc") {
        displayMessage("Nachricht an " + data.name + " geflüstert", data.message);
    }
    if (data.type === "directTo") {
        displayMessage(data.name, data.message, "directed");
    }
    if (data.type === "roominfo") {
        updateRoomInfo(data.message);
    }
};

function updateRoomInfo(desc) {
    jQuery("#roomDescription").text(desc);
}

function refreshUserList(clients) {
    jQuery("#userList").html("");
    for (var i = 0; i < clients.length; i++) {
        if (users.indexOf(clients[i].nickname) === -1) {
            users.push(clients[i]["nickname"]);
        }
        var adminText = (clients[i]["isAdmin"]) ? " (*)" : "";
        jQuery("#userList").append(jQuery("<div class='user'></div>").text(clients[i]["nickname"] + adminText));
    }
}

function refreshRoomList(rooms) {
    jQuery("#roomlist").html("");
    for (var i = 0; i < rooms.length; i++) {
        jQuery("#roomlist").append(jQuery("<option value='"+ rooms[i].roomId +"'></div>").text(rooms[i].name));
    }
}

function sendMessage() {
    var messageText = jQuery("#message").val().trim();
    if (messageText !== "") {
        ws.send(messageText);
    }
    jQuery("#message").val("");
    jQuery("#message").focus();
}

function switchRoom(roomId) {
    ws.send("/join " + roomId);
}

function displayMessage(sender, text, elemClass) {
    elemClass = (typeof elemClass !== 'undefined') ?  elemClass : "";
    var label = jQuery("<span class='label'></span>").text(sender + ": ");
    var message = jQuery("<span class='im " + elemClass + "'></span>").append(text);
    var block = jQuery("<div></div>").append(label).append(message);
    jQuery("#messages").append(block).scrollTop(jQuery("#messages")[0].scrollHeight);
}



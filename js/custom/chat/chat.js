
jQuery(document).ready(function(){
    
    jQuery("#send").on('click', function(event){
        event.preventDefault();
        sendMessage();
    });
    
    
    jQuery("#chat_form").on('submit', function(event){
        event.preventDefault();
        sendMessage();
    });
    
});

var ws = new WebSocket("ws://192.168.178.31:8181");
ws.onopen = function (e) {
    console.log('Connection to server opened');
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
    if (data.type === "whisper") {
        displayMessage(data.name + " flüstert", data.message, "msg");
    }
    if (data.type === "whisperAcc") {
        displayMessage("Nachricht an " + data.name + " geflüstert", data.message);
    }
    if (data.type === "directTo") {
        displayMessage(data.name, data.message, "directed");
    }
};


function refreshUserList(clients) {
    jQuery("#userList").html("");
    for (var i = 0; i < clients.length; i++) {
        var adminText = (clients[i]["isAdmin"]) ? " (*)" : "";
        jQuery("#userList").append(jQuery("<div class='user'></div>").text(clients[i]["nickname"] + adminText));
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

function displayMessage(sender, text, elemClass = "") {
    elemClass = (typeof elemClass !== 'undefined') ?  elemClass : "";
    var label = jQuery("<span class='label'></span>").text(sender + ": ");
    var message = jQuery("<span class='im " + elemClass + "'></span>").append(text);
    var block = jQuery("<div></div>").append(label).append(message);
    jQuery("#messages").append(block).scrollTop(jQuery("#messages")[0].scrollHeight);
}



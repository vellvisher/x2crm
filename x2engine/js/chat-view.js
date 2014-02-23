function addMessage(peerName, message) {
    $("#message-box").append('<div><span class="peer">' + peerName + '</span>: ' + message +
        '</div>');
}

function updatedPeers() {
    var participantText = "Chat with ";
    $.each(PEER_NAMES, function(key, value) {
        participantText += value + ",";
    });
    participantText = participantText.slice(0, -1);
    if (PEER_NAMES.length == 0) {
        participantText = "";
    }
    $('#chat-participants').text(participantText);

}

function peerConnected() {
    $('#send-button').enable();
    $('#make-call').enable();
}

$(function() {
    // Prepare file drop box.
    var box = $('#box');
    box.on('dragenter', doNothing);
    box.on('dragover', doNothing);
    box.on('drop', function(e){
        e.originalEvent.preventDefault();
        var file = e.originalEvent.dataTransfer.files[0];
        eachActiveConnection(function(c) {
            if (c.label === 'file') {
                c.send(file);
                addMessage("You", msg);
            }
        });
    });

    // Close a connection.
    // $('#close').click(function() {
    //     eachActiveConnection(function(c) {
    //         c.close();
    //     });
    // });

    // Send a chat message to all active connections.
    $('#send').submit(function(e) {
        e.preventDefault();
        // For each active connection, send the message.
        var msg = $('#text').val();
        eachActiveConnection(function(c) {
            if (c.label === 'chat') {
                c.send(JSON.stringify({message: msg}));
                addMessage("You", msg);
            }
        });
        $('#text').val('');
        $('#text').focus();
    });

    // Show browser version
    $('#browsers').text(navigator.userAgent);
});

// Make sure things clean up properly.

window.onunload = window.onbeforeunload = function(e) {
    if (!!peer && !peer.destroyed) {
        peer.destroy();
    }
};

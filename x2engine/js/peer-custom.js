// Connect to PeerJS, have server assign an ID instead of providing one
// Showing off some of the configs available with PeerJS :).
HOST_NAME = '/';
PEER_SERVER_PORT = 9001;
var peer = new Peer({
    // Set API key for cloud server (you don't need this if you're running your
    // own.
    host: HOST_NAME,
    port:PEER_SERVER_PORT,
});

var connectedPeers = {};
var PEER_NAMES = {};

// Show this peer's ID.
peer.on('open', function(id){
    $('#pid').text(id);
    $('#chat-room-id').val(id);
    serverConnected();
});

// Await connections from others
peer.on('connection', connect);

// Handle a connection object.
function connect(c) {
    console.log('handling connection');
    // Handle a chat connection.
    if (c.label === 'chat') {
        console.log('handling chat connection');
        CONSTANTS.OTHER_ID = c.peer;
        console.log("other id " + CONSTANTS.OTHER_ID);
        def = c;
        c.on('open', function() {
            peerConnected();
            c.send(JSON.stringify({name: CONSTANTS.FULL_NAME}));
        });
        var chatbox = $('#chatbox').addClass('active').attr('id', c.peer);
        var messages = $('#message-box').html('<div><em>Peer connected.</em></div>');

        // Select connection handler.
        chatbox.on('click', function() {
            if ($(this).attr('class').indexOf('active') === -1) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
        $('.filler').hide();
        // $('#connections').append(chatbox);

        c.on('data', function(data) {
            abc = data;
            data = JSON.parse(data);
            console.log(data);
            if ('name' in data) {
                PEER_NAMES[c.peer] = data.name;
                updatedPeers();
            }
            if ('message' in data) {
                if(data.message == "bfa99df33b137bc8fb5f5407d7e58da8") {
                    manualEnd();
                } else {
                    addMessage(PEER_NAMES[c.peer], data.message);
                }
                // messages.append('<div><span class="peer">' + PEER_NAMES[c.peer] + '</span>: ' + data.message +
                //     '</div>');
            }
        });
        c.on('close', function() {
            messages.append(PEER_NAMES[c.peer] + ' has left the chat.');
            chatbox.remove();
            if ($('.connection').length === 0) {
                $('.filler').show();
            }
            delete connectedPeers[c.peer];
            delete PEER_NAMES[c.peer];
            updatedPeers();
        });

        c.on('error', function(error) {console.log(error);});

        // c.send(JSON.stringify({ name : CONSTANTS.FULL_NAME}));
    } else if (c.label === 'file') {
        c.on('data', function(data) {
            // If we're getting a file, create a URL for it.
            if (data.constructor === ArrayBuffer) {
                var dataView = new Uint8Array(data);
                var dataBlob = new Blob([dataView]);
                var url = window.URL.createObjectURL(dataBlob);
                $('#' + c.peer).find('.messages').append('<div><span class="file">' +
                    PEER_NAMES[c.peer] + ' has sent you a <a target="_blank" href="' + url + '">file</a>.</span></div>');
            }
        });
    }
    connectedPeers[c.peer] = 1;
    $('#actions').show();
    $('#invite').hide();
}

function connectToPeer(peerId) {
    if (!connectedPeers[peerId]) {
        // Create 2 connections, one labelled chat and another labelled file.
        var c = peer.connect(peerId, {
            label: 'chat',
                serialization: 'none',
                metadata: {message: 'hi i want to chat with you!',
                           name: CONSTANTS.FULL_NAME}
        });
        c.on('open', function() {
            peerConnected();
            c.send(JSON.stringify({name: CONSTANTS.FULL_NAME}));
            connect(c);
        });
        c.on('error', function(err) { alert(err); });
        var f = peer.connect(peerId, { label: 'file', reliable: true });
        f.on('open', function() {
            connect(f);
        });
        f.on('error', function(err) { alert(err); });
    }
    connectedPeers[peerId] = 1;
}

function doNothing(e){
    e.preventDefault();
    e.stopPropagation();
}

// Goes through each active peer and calls FN on its connections.
function eachActiveConnection(fn) {
    var checkedIds = {};
    $.each(connectedPeers, function (peerId) {
        if (!checkedIds[peerId]) {
            var conns = peer.connections[peerId];
            for (var i = 0, ii = conns.length; i < ii; i += 1) {
                var conn = conns[i];
                fn(conn);
            }
        }
        checkedIds[peerId] = 1;
    });
}


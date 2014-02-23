// Click handlers setup
$(function() {

	navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

	// Retry if getUserMedia fails
	$('#getMedia-retry').click(function() {
		$('#getMedia-error').hide();
		getMedia();
	});

	// Get things started
	getMedia();
	$('#endCallButton').hide();
	$('#getMedia-error').hide();
	$('#actions').hide();

	// Receiving a call
	peer.on('call', function(call) {
		videoCallButton();
		// Answer the call automatically (instead of prompting user) for demo purposes
		call.answer(window.localStream);
		endCallButton(call);
	});
	peer.on('error', function(err) {
		alert(err.message);
		// Return to step 2 if error occurs
		videoCallButton();
	});

	$('#make-call').click(function() {
		videoCallButton();
		// Initiate a call!
		var call = peer.call(CONSTANTS.OTHER_ID, window.localStream);

		endCallButton(call);
	});

	$('#end-call').click(function() {
		eachActiveConnection(function(c) {
			if (c.label === 'chat') {
				c.send(JSON.stringify({message:"bfa99df33b137bc8fb5f5407d7e58da8"}));
			}
		});
		window.existingCall.close();
		hideOtherVideo();
	});

});

function manualEnd() {
	window.existingCall.close();
	hideOtherVideo();
}

function getMedia() {
	// Get audio/video stream
	navigator.getUserMedia({
		audio: true,
		video: true
	}, function(stream) {
		// Set your video displays
		$('#my-video').prop('src', URL.createObjectURL(stream));

		window.localStream = stream;
		videoCallButton();
	}, function() {
		$('#getMedia-error').show();
	});
}

function videoCallButton() {
	console.log("videoCallButton");
	$('#getMedia, #endCallButton').hide();
	$('#videoCallButton').show();
	$('#their-video-container').show();
}

function hideOtherVideo() {
	videoCallButton();
	$('#their-video-container').hide();
}

function endCallButton(call) {
	// Hang up on an existing call if present
	if (window.existingCall) {
		window.existingCall.close();
	}

	// Wait for stream on the call, then set peer video display
	call.on('stream', function(stream) {
		$('#their-video').prop('src', URL.createObjectURL(stream));
	});

	// UI stuff
	window.existingCall = call;
	$('#their-id').text(call.peer);
	call.on('close', hideOtherVideo);
	$('#getMedia, #videoCallButton').hide();
	$('#endCallButton').show();
}
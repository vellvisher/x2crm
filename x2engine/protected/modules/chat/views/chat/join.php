<head>
<script>
    CONSTANTS = {}
    CONSTANTS.FULL_NAME = "<?php echo $fullName; ?>";
    CONSTANTS.CHATROOM_ID = "<?php echo $chatroom_id ?>";
    CONSTANTS.OTHER_ID = CONSTANTS.CHATROOM_ID;
    function serverConnected() {
        connectToPeer(CONSTANTS.CHATROOM_ID);
    }
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/peer.min.js');
// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/peer.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chat-view.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/peer-custom.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/video-chat.js', CClientScript::POS_END);
?>

</head>

<body>
    <h1>Chat</h1>
    <h2 id='chat-user-hi'></h2>

  <div id="actions">
    Your PeerJS ID is <span id="pid"></span><br>
    <b>Chat message: </b>
    <form id="send">
      <input type="text" id="text" placeholder="Enter message"><input class="button" type="submit" value="Send to peers" id="send-button" disabled="disabled">
    </form>
  </div>
<!-- Make calls to others -->
  <b>Video Call: </b>
  <div id="step2">
    <form id="video-call">
      <input type="button" value="Video Call" id="make-call" disabled="disabled">
    </div>
  </div>

  <!-- video call -->
  <div id="videos">
  <div class="pure-u-2-3" id="video-container">
    My Video: <br>
    <video id="my-video" muted="true" autoplay></video>
    
    <div id="their-video-container">
      Other Video: <br>
      <video id="their-video" autoplay></video>
    </div>
  </div>
</div>


  <!-- Get local audio/video stream -->
  <div id="step1">
    <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
    <div id="step1-error">
      <p>Failed to access the webcam and microphone. Make sure to run this demo on an http server and click allow when asked for permission by the browser.</p>
      <a href="#" class="pure-button pure-button-error" id="step1-retry">Try again</a>
    </div>
  </div>


  <!-- Call in progress -->
  <div id="step3">
    <form>
      <input type="button" value="End Call" id="end-call">
    </form>
  </div>



  <div id="wrap"><div id="connections"><span class="filler">You have not yet
        made any connections.</span><div id="chatbox"><h1 id="chat-participants"></h1><div class="messages" id="message-box"></div></div></div>
    <div class="clear"></div></div>

  <div id="box" style="background: #fff; font-size: 18px;padding:40px 30px; text-align: center;">
    Drag file here to send to active connections.
  </div>
  <div class="warning browser">
    <div class="important">Your browser version: <span id="browsers"></span><br>
  Currently <strong>Firefox 22+ and Google Chrome 26.0.1403.0 or above</strong> is required.</strong></div>For more up to date compatibility
information see <a href="http://peerjs.com/status">PeerJS WebRTC
  Status</a><br>Note that this demo may also fail if you are behind
stringent firewalls or both you and the remote peer and behind symmetric
NATs.

<div class="log" style="color:#FF7500;text-shadow:none;padding:15px;background:#eee"><strong>Connection status</strong>:<br></div>
</div>
</body>
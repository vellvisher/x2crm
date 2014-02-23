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
    <h2 id='chat-user-hi'></h2>

<div id="actions">
  <div>
    <b>Chat message: </b>
    <form id="send">
      <input type="text" id="text" placeholder="Enter message"><input class="button" type="submit" value="Send" id="send-button" disabled="disabled">
    </form>
  </div>

  <div id="wrap"><div id="connections"><span class="filler">You have not yet
        made any connections.</span><div id="chatbox"><h1 id="chat-participants"></h1><div class="messages" id="message-box"></div></div></div>
    <div class="clear"></div></div>

  <div id="box" style="background: #fff; font-size: 18px;padding:40px 30px; text-align: center;">
    Drag file here to send to active connections.
  </div>

<!-- Make calls to others -->
  <b>Video Call: </b>
  <div id="videoCallButton">
    <form id="video-call">
      <input type="button" value="Video Call" id="make-call" disabled="disabled">
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
  <div id="getMedia">
    <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
    <div id="getMedia-error">
      <p>Failed to access the webcam and microphone. Click allow when asked for permission by the browser.</p>
      <a href="#" class="pure-button pure-button-error" id="getMedia-retry">Try again</a>
    </div>
  </div>


  <!-- Call in progress -->
  <div id="endCallButton">
    <form>
      <input type="button" value="End Call" id="end-call">
    </form>
  </div>
</div>
</body>
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
<div class="page-title">
    <h2 id="chat-participants">Chat</h2>
</div>

<div id="actions" style="padding:5px;">
    <form id="send" action="">
        <table><tr>
                <td>
                    <input type="text" id="text" size="100" placeholder="Enter message">
                </td></tr><tr><td>
                    <input class="button" type="submit" value="Send" id="send-button" disabled="disabled">
                </td></tr>
        </table>
    </form>

  <div id="wrap"><div id="connections"><span class="filler">You have not yet
        made any connections.</span><div id="chatbox"><div class="messages" id="message-box"></div></div></div>
    <div class="clear"></div></div>

  <div id="box" style="background: #eee; border:2px solid black; font-size: 18px;padding:40px 30px; text-align: center;">
    Drag file here to send to active connections.
  </div>

<!-- Make calls to others -->
  <div id="videoCallButton">
    <form id="video-call" action="">
      <input type="button" value="Start Video Call" id="make-call" disabled="disabled">
    </form>
    </div>

    <!-- video call -->
    <div id="videos">
        <div id="video-container">
           <video id="my-video" height="220px" width="300px" muted="true" autoplay></video>
        </div>
        <div id="their-video-container">
           <video id="their-video" height="440px" width="600px" autoplay></video>
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
    <form action="">
      <input type="button" value="End Call" id="end-call">
    </form>
  </div>
</div>
</body>

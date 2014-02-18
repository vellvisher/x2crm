<head>
<script>
    CONSTANTS = {}
    CONSTANTS.FULL_NAME = "<?php echo $fullName; ?>";
    CONSTANTS.ALL_USERS = <?php echo $all_users; ?>;
    function serverConnected() {
        $('#chat-room-invite').enable();
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

<script>

    $(function() {
        $('#chat-invite-box').autocomplete({
            'minLength':'1',
            'source':CONSTANTS.ALL_USERS
        });

        $('#chat-invite-form').ajaxForm({url:'invite', type:'post', resetForm:true, success:function() {alert('Invited!');},
            error:function() { alert('Sorry, could not post the invite...');}});
    });

</script>
</head>

<body>
    <h1>Chat</h1>
    <h2 id='chat-user-hi'></h2>
    <span> <p>
    Invite users to the chat from the box below:
    </p></span>

    <form id="chat-invite-form">
        <input id="chat-invite-box" name="username" type="text"/>
        <input type="hidden" id="chat-room-id" name="chatroom_id" value=""/>
        <input type="submit" value="Invite" id="chat-room-invite" disabled="disabled"/>
    </form>

  <div id="actions">
    Your PeerJS ID is <span id="pid"></span><br>
    <form id="send">
      <input type="text" id="text" placeholder="Enter message"><input class="button" type="submit" value="Send to peers" id="send-button" disabled="disabled">
    </form>
  </div>

  <div id="wrap"><div id="connections"><span class="filler">You have not yet
        made any connections.</span><div id="chatbox"><h1 id="chat-participants"></h1><div class="messages" id="message-box"></div></div></div>
    <div class="clear"></div></div>

  <div id="box" style="background: #fff; font-size: 18px;padding:40px 30px; text-align: center;">
    Drag file here to send to active connections.
  </div>

  <!-- video call -->
  <div class="pure-u-2-3" id="video-container">
    <video id="their-video" autoplay></video>
    <video id="my-video" muted="true" autoplay></video>
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
    <p><a href="#" class="pure-button pure-button-error" id="end-call">End call</a></p>
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

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
            error:function(data) {if(data.responseText == "duplicate") alert('This user has already been invited'); else alert('Sorry, could not post the invite...');}});
    });

</script>
</head>

<body>
    <div class="page-title">
        <h2 id="chat-participants">Chat</h2>
    </div>
    <div id="invite">
    <span> <p>
    Invite users to the chat from the box below:
    </p></span>

    <?php echo CHtml::form('', 'post', array('id'=>'chat-invite-form')); ?>
        <input id="chat-invite-box" name="username" type="text"/>
        <input type="hidden" id="chat-room-id" name="chatroom_id" value=""/>
        <input type="submit" value="Invite" id="chat-room-invite" disabled="disabled"/>
    </form>
  </div>

    <br>
<!-- Get local audio/video stream -->
  <div id="getMedia">
    <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
    <div id="getMedia-error">
      <p>Failed to access the webcam and microphone. Click allow when asked for permission by the browser.</p>
      <a href="#" class="pure-button pure-button-error" id="getMedia-retry">Try again</a>
    </div>
  </div>

<div id="actions">
  <table><tr>
    <form id="send">
        <td>
            <input type="text" id="text" size="100" placeholder="Enter message">
        </td></tr><tr><td>
            <input class="button" type="submit" value="Send" id="send-button" disabled="disabled">
        </td>
    </form>
  </table>

  <div id="wrap"><div id="connections"><span class="filler">You have not yet
        made any connections.</span><div id="chatbox"><div class="messages" id="message-box"></div></div></div>
    <div class="clear"></div></div>

  <div id="box" style="background: #eee; border:2px solid black; font-size: 18px;padding:40px 30px; text-align: center;">
    Drag file here to send to active connections.
  </div>

  <div id="videoCallButton">
    <form id="video-call">
      <input type="button" value="Start Video Call" id="make-call" disabled="disabled">
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

  <!-- Call in progress -->
  <div id="endCallButton">
    <form>
      <input type="button" value="End Call" id="end-call">
    </form>
  </div>
</div>
</body>

<head>
<script>
    CONSTANTS = {}
    CONSTANTS.FULL_NAME = "<?php echo $fullName; ?>";
    CONSTANTS.ALL_USERS = <?php echo $all_users; ?>;
    CONSTANTS.FILE_ID = "<?php echo $file_id; ?>";
</script>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/codemirror/lib/codemirror.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/firepad-min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/codemirror.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/firepad.css');
?>

  <!-- Include Firebase -->
  <script src="https://cdn.firebase.com/v0/firebase.js"></script>

  <style>
    /* html { height: 100%; } */
    /* body { margin: 0; height: 100%; position: relative; } */
      /* Height / width / positioning can be customized for your use case.
         For demo purposes, we make firepad fill the entire browser. */
    /* .firepad { */
    /*   position: absolute; left: 0; top: 0; bottom: 0; right: 0; height: auto; */
    /* } */
  </style>
</head>

<script>

    $(function() {
        $('#editor-invite-box').autocomplete({
            'minLength':'1',
            'source':CONSTANTS.ALL_USERS
        });

        $('#editor-invite-form').ajaxForm({url:'invite', type:'post', resetForm:true, success:function() {alert('Invited!');},
            error:function(data) {if(data.responseText == "duplicate") alert('This user has already been invited'); else alert('Sorry, could not post the invite...');}});
    });

</script>

    <div id="editor-invite">
    <span> <p>
    Invite users to the editor from the box below:
    </p></span>

    <form id="editor-invite-form">
        <input id="editor-invite-box" name="username" type="text"/>
        <input type="hidden" id="editor-room-id" name="file_id" value=""/>
        <input type="submit" value="Invite" id="editor-room-invite" disabled="disabled"/>
    </form>
  </div>

  <div id="editor-invite"></div>
  <div id="firepad" style="display:none"></div>

  <script>
    //// Initialize Firebase.
    var firepadRef = new Firebase('https://sweltering-fire-9736.firebaseio.com/firepads/' + CONSTANTS.FILE_ID);
    // TODO: Replace above line with:
    // var firepadRef = new Firebase('<YOUR FIREBASE URL>');

    //// Create CodeMirror (with lineWrapping on).
    var codeMirror = CodeMirror(document.getElementById('firepad'), { lineWrapping: true });

    //// Create Firepad (with rich text toolbar and shortcuts enabled).
    var firepad = Firepad.fromCodeMirror(firepadRef, codeMirror,
        { richTextToolbar: true, richTextShortcuts: true });

    //// Initialize contents.
    firepad.on('ready', function() {
        $("#firepad").show();
        if (firepad.isHistoryEmpty()) {
            firepad.setHtml(
                "Your document should be here"
            );
      }
    });
  </script>

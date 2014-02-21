<head>
<script>
    CONSTANTS = {}
    CONSTANTS.FULL_NAME = "<?php echo $fullName; ?>";
    CONSTANTS.ALL_USERS = <?php echo $all_users; ?>;
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

  <div id="firepad"></div>

  <script>
    //// Initialize Firebase.
    var firepadRef = new Firebase('https://sweltering-fire-9736.firebaseio.com');
    // TODO: Replace above line with:
    // var firepadRef = new Firebase('<YOUR FIREBASE URL>');

    //// Create CodeMirror (with lineWrapping on).
    var codeMirror = CodeMirror(document.getElementById('firepad'), { lineWrapping: true });

    //// Create Firepad (with rich text toolbar and shortcuts enabled).
    var firepad = Firepad.fromCodeMirror(firepadRef, codeMirror,
        { richTextToolbar: true, richTextShortcuts: true });

    //// Initialize contents.
    firepad.on('ready', function() {
      if (firepad.isHistoryEmpty()) {
        firepad.setHtml(
            '<span style="font-size: 24px;">Rich-text editing with <span style="color: red">Firepad!</span></span><br/>\n' +
            '<br/>' +
            '<div style="font-size: 18px">' +
            'Supports:<br/>' +
            '<ul>' +
              '<li>Different ' +
                '<span style="font-family: impact">fonts,</span>' +
                '<span style="font-size: 24px;"> sizes, </span>' +
                '<span style="color: blue">and colors.</span>' +
              '</li>' +
              '<li>' +
                '<b>Bold, </b>' +
                '<i>italic, </i>' +
                '<u>and underline.</u>' +
              '</li>' +
              '<li>Lists' +
                '<ol>' +
                  '<li>One</li>' +
                  '<li>Two</li>' +
                '</ol>' +
              '</li>' +
              '<li>Undo / redo</li>' +
              '<li>Cursor / selection synchronization.</li>' +
              '<li>And it\'s all fully collaborative!</li>' +
            '</ul>' +
            '</div>');
      }
    });
  </script>

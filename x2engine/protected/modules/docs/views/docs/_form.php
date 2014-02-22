<?php

$autosaveUrl = $this->createUrl('autosave').'?id='.$model->id; ?>


<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/codemirror/lib/codemirror.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/firepad-min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/codemirror.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/firepad.css');
?>

<script>
    CONSTANTS = {}
    CONSTANTS.FILE_ID = "something";
</script>

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

<script>
var typingTimer;

function autosave() {
	window.docEditor.updateElement();
	$("#savetime").html("'.addslashes(Yii::t('app','Saving...')).'");
	$.post("'.$autosaveUrl.'", $("form").serializeArray(), function(response) {
		$("#savetime").html(response);
	});
}

function setupAutosave() {
	if($.browser.msie)
		return;
	// save after 1.5 seconds when the user is done typing

	window.docEditor.document.on("keyup",function(e) {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(autosave, 1500);
	});
	window.docEditor.on("saveSnapshot",function(e) {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(autosave, 1500);
	});
	window.docEditor.document.on("keydown",function(){ clearTimeout(typingTimer); });
};
</script>

<!-- Yii::app()&#45;>clientScript&#45;>registerScript('doc&#45;editor',$js,CClientScript::POS_READY); -->

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'=>'docs-form',
        'enableAjaxValidation'=>false,
    ));
?>
<div class="form no-border">
	<div class="row">
		<div class="cell">
			<?php echo $form->errorSummary($model); ?>
			<?php echo $form->label($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<div class="cell">
			<?php echo $form->label($model,'visibility'); ?>
			<?php echo $form->dropDownList($model,'visibility',array(1=>Yii::t('app','Public'),0=>Yii::t('app','Private'))); ?>
			<?php echo $form->error($model,'visibility'); ?>
		</div>
		<div class="cell right">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Save'),array('class'=>'x2-button float')); ?>
		</div>
	</div>
	<div class="row">
		<span id="savetime">
			<?php if(isset($_GET['saved'])){
				$date=date("g:i:s A",$_GET['time']);
				echo Yii::t('docs', 'Saved at') ." $date";
			} ?>
		</span>
	</div>
	<div class="row" style="margin-top:5px;">
		<?php
		if($model->isNewRecord && isset($users)){
			echo $form->label($model,'editPermissions');
			echo $form->dropDownList($model,'editPermissions',$users,array('multiple'=>'multiple','size'=>'5'));
			echo $form->error($model,'editPermissions');
		}
		echo $form->error($model,'text');
		echo $form->textArea($model,'text',array('id'=>'input'));
		?>
	</div>

</div>
<?php echo $form->error($model,'text'); ?>

<?php $this->endWidget(); ?>

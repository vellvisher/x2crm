<head>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/codemirror.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/firepad.js', CClientScript::POS_END);
// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/firepad-min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/codemirror.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/firepad.css');
?>

<script>
    CONSTANTS = {}
    CONSTANTS.IS_CREATE = false;
    <?php if ($model->isNewRecord) { ?>
        CONSTANTS.IS_CREATE = true;
    <?php } ?>
    if (CONSTANTS.IS_CREATE) {
        //TODO: Fix people getting the same id at the same time
        CONSTANTS.FILE_ID = "newFile" + new Date().getTime();
    }
</script>

  <!-- Include Firebase -->
  <script src="https://cdn.firebase.com/v0/firebase.js"></script>

</head>

  <script>
    function UNDO_MANAGER_LISTENER () {
        if (!CONSTANTS.IS_CREATE) {
            // $('#doc-rev-form-text').val(firepad.getHtml());
            $('#doc-rev-form-text').val(btoa(firepad.getText()));
            $('#doc-rev-form').ajaxSubmit({url:'saveRevision', type:'post', resetForm:true, success:function() {console.log('revision sent');},
                error:function(data) {console.log(data, 'error');}});
        }
    }
    $(function() {
        //// Initialize Firebase.
        firepadRef = new Firebase('https://sweltering-fire-9736.firebaseio.com/firepads/' + CONSTANTS.FILE_ID);

        //// Create CodeMirror (with lineWrapping on).
        var codeMirror = CodeMirror(document.getElementById('firepad'), { lineWrapping: true });

        //// Create Firepad (with rich text toolbar and shortcuts enabled).
        firepad = Firepad.fromCodeMirror(firepadRef, codeMirror,
            { richTextToolbar: true, richTextShortcuts: true });

        //// Initialize contents.
        firepad.on('ready', function() {
            firepad.setHtml(
                "<?php echo $model->text ?>");
            $("#firepad").show();
            firepad.codeMirror_.on('change', function() {
                // $("#input").text(firepad.getHtml());
                $("#input").text(firepad.getText());
            });
        });

    });
  </script>

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
		echo $form->textArea($model,'text',array('id'=>'input', 'style'=>'display:none'));
		?>
	</div>
        <div id="firepad" style="display:none"></div>
</div>
<?php echo $form->error($model,'text'); ?>

<?php $this->endWidget(); ?>
<form style="display:none" id="doc-rev-form" action="saveRevision" method="post">
    <input name="id" type="text" id="doc-rev-form-id" value="<?php echo $model->id ?>"></input>
    <input name="doc-text" type="text" id="doc-rev-form-text"></input>
    <input type="submit" ></input>
</form>

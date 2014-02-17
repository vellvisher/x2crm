<?php
// editor javascript file
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/ckeditor/ckeditor.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/ckeditor/adapters/jquery.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/emailEditor.js');

$autosaveUrl = $this->createUrl('autosave').'?id='.$model->id;

$js ='
var typingTimer;

function autosave() {
    window.newsletterEditor.updateElement();
    $("#savetime").html("'.addslashes(Yii::t('app','Saving...')).'");
    $.post("'.$autosaveUrl.'", $("form").serializeArray(), function(response) {
        $("#savetime").html(response);
    });
}

if(window.newsletterEditor)
    window.newsletterEditor.destroy(true);
window.newsletterEditor = createCKEditor("input",{
    fullPage:true,
    height:600
}'.($model->isNewRecord? '' : ',setupAutosave').');
function setupAutosave() {
    if($.browser.msie)
        return;
    // save after 1.5 seconds when the user is done typing

    window.newsletterEditor.document.on("keyup",function(e) {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(autosave, 1500);
    });
    window.newsletterEditor.on("saveSnapshot",function(e) {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(autosave, 1500);
    });
    window.newsletterEditor.document.on("keydown",function(){ clearTimeout(typingTimer); });
}';

Yii::app()->clientScript->registerScript('newsletter-editor',$js,CClientScript::POS_READY);

$form = $this->beginWidget('CActiveForm', array(
    'id'=>'newsletters-form',
    'enableAjaxValidation'=>false,
)); ?>
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
                echo Yii::t('newsletters', 'Saved at') ." $date";
            } ?>
        </span>
    </div><?php  ?>
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

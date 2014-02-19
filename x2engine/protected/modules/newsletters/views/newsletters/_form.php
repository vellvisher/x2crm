<?php
// editor javascript file
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/ckeditor/ckeditor.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/ckeditor/adapters/jquery.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->getBaseUrl().'/js/emailEditor.js');

$js ='
var typingTimer;

if(window.newsletterEditor)
    window.newsletterEditor.destroy(true);
window.newsletterEditor = createCKEditor("input",{
    fullPage:true,
    height:600
});';

Yii::app()->clientScript->registerScript('newsletter-editor',$js,CClientScript::POS_READY);

$form = $this->beginWidget('CActiveForm', array(
    'id'=>'newsletters-form',
    'enableAjaxValidation'=>true,
)); ?>
<div class="form no-border">
    <div class="row">
        <div class="cell">
        <?php
            echo $form->errorSummary($model);
            echo $form->label($model,'name');
            echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100));
            echo $form->error($model,'name');
        ?>
        </div>
        <div>
        <?php
            echo $form->label($model,'type');
            echo $form->dropDownList($model,'type',$model->types());
            echo $form->error($model,'type');
        ?>
        </div>
        <div class="cell">
        <?php
            echo $form->errorSummary($model);
            echo $form->label($model,'subject');
            echo $form->textField($model,'subject',array('size'=>100,'maxlength'=>150));
            echo $form->error($model,'subject');
        ?>
        </div>
        <div class="cell right">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'x2-button float')); ?>
        </div>
    </div>
    <div class="row">
        <span id="savetime">
            <?php if(isset($_GET['saved'])){
                $date=date("g:i:s A",$_GET['time']);
                echo "Saved at $date";
            } ?>
        </span>
    </div>
    <div class="row" style="margin-top:5px;">
    <?php
        echo $form->error($model,'body');
        echo $form->textArea($model,'body',array('id'=>'input'));
    ?>
    </div>

</div>
<?php echo $form->error($model,'body'); ?>

<?php $this->endWidget(); ?>

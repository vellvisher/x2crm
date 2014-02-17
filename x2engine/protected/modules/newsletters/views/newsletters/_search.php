<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'text'); ?>
        <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'createdBy'); ?>
        <?php echo $form->textField($model,'createdBy',array('size'=>40,'maxlength'=>40)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'updatedBy'); ?>
        <?php echo $form->textField($model,'updatedBy',array('size'=>40,'maxlength'=>40)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
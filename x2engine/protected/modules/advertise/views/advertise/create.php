<div class="page-title icon newsletters">
    <h2>Create Advertisement</h2>
</div>
<!-- Preview dialog-->
<?php
?>
<div id="preview-dialog" style="display:none;width:450px;height:500px;">
    <iframe src="" id="advertise-Iframe" frameBorder="0" width="100%" style="background:#fff;"></iframe>
    <a class="x2-button" href="#" onclick="$('#advertise-form').submit();">Publish</a>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'advertise-form'
)); ?>
    <div class="form no-border" style="padding:10px;">
        <div class="row">
            <div class="cell">

            <?php
                echo $form->label($model,'name');
                echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100));
            ?>
            </div>
            <div class="cell">
            <?php
                echo $form->label($model,'phone');
                echo $form->textField($model,'phone',array('size'=>15,'maxlength'=>30));
            ?>
            </div>
        </div>
        <div class="row">
            <div class="cell">
            <?php
                echo $form->label($model,'email');
                echo $form->textField($model,'email',array('size'=>70,'maxlength'=>100));
            ?>
            </div>
        </div>
        <div class="row">
            <div class="cell">
            <?php
                echo $form->label($model,'address');
                echo $form->textArea($model,'address');
            ?>
            </div>
        </div>
        <div class="row">
            <div class="cell">
            <?php
                echo $form->label($model,'budget');
                echo $form->dropDownList($model,'budget',$budgets);
            ?>
            </div>
        </div>
        <div class="row">
            <div class="cell">
            <?php
                echo $form->label($model,'url');
                echo $form->textField($model,'url',array('size'=>100,'maxlength'=>255,'id'=>'source-url'));
            ?>
            </div>
        </div>
        <div class="cell" style="margin-top:10px;">
            <?php
                echo CHtml::link('Preview','#',
                    array(
                        'class'=>'x2-button',
                        'onclick'=>'$("#preview-dialog iframe").attr("src", $("#source-url").val());$("#preview-dialog").dialog();'));
            ?>
        </div>

    </div>
<?php $this->endWidget(); ?>
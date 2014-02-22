<?php

Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');

$this->setPageTitle($model->name);
$themeUrl = Yii::app()->theme->getBaseUrl();

$this->actionMenu = $this->formatMenu(array(
    array('label'=> 'List Newsletters', 'url'=>array('index')),
    array('label'=> 'Create Newsletter', 'url'=>array('create')),
));

Yii::app()->getClientScript()->registerScript('newsletterIframeAutoExpand','
$("#newsletterIframe").load(function() {
    $(this).height($(this).contents().height());
});
$(window).resize(function() {
    $("#newsletterIframe").height($("#newsletterIframe").height(650).contents().height());
});
',CClientScript::POS_READY);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-ui-timepicker-addon.js',CClientScript::POS_END);
Yii::app()->getClientScript()->registerScript('datepicker','
    $(function() {
        $("#startDate,#endDate").datetimepicker({
            dateFormat: "yy-mm-dd",
            altFormat: "@",
        });
    });
    ',CClientScript::POS_READY);
?>

<div class="page-title icon newsletters">
    <h2>
        <span class="no-bold">Newsletter</span>
        <?php echo $model->name; ?>
    </h2>
    <?php if (!$model->published) {
        echo $this->renderPartial('_publish', array(
            'model'=>$model,
            'action' => Yii::app()->getBaseUrl(true)."/index.php/newsletters/publish/".$model->id
    ));
    } else { ?>
    <?php } ?>

<?php
    if (!$model->published) {
        echo CHtml::link(
            '<span></span>',
            '#',
            array(
                'title'=>"Publish",
                'class'=>'x2-button x2-hint icon publish right',
                'onclick'=>'$("#publish-dialog").dialog()'));
    } else {
        echo CHtml::link(
        '<span></span>',
        "#",
        array(
            'submit'=>array('unpublish','id'=>$model->id),
            'confirm'=> 'Are you sure you want to unpublish this newsletter?',
            'class'=>'x2-button x2-hint icon unpublish right',
            'title'=> 'Unpublish'));
    }

    echo CHtml::link(
        '<span></span>',
        "#",
        array(
            'submit'=>array('delete','id'=>$model->id),
            'confirm'=> 'Are you sure you want to delete this item?',
            'class'=>'x2-button x2-hint icon delete right',
            'title'=> 'Delete'));
    echo CHtml::link(
        '<span></span>',
        array('/newsletters/newsletters/edit','id'=>$model->id),
        array('class'=>'x2-button x2-hint icon edit right','title'=> 'Edit'));
    echo CHtml::link(
        '<span></span>',
        array('/newsletters/newsletters/create','duplicate'=>$model->id),
        array('class'=>'x2-button icon copy right x2-hint','title'=> 'Make a copy'));
?>
</div>
<?php echo $this->renderPartial('_iframe', array('model'=>$model)); ?>
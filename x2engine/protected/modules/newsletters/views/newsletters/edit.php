<?php
$title = Yii::t('newsletters','Edit Newsletter:');

$pieces = explode(", ",$model->editPermissions);
$user = Yii::app()->user->getName();

$this->actionMenu = $this->formatMenu(array(
    array('label'=>Yii::t('newsletters','List Newsletters'), 'url'=>array('index')),
    array('label'=>Yii::t('newsletters','Create Newsletter'), 'url'=>array('create')),
));

?>

<div class="page-title icon newsletters">
    <h2>
        <span class="no-bold"><?php echo $title; ?></span>
        <?php echo CHtml::encode($model->name); ?>
    </h2>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
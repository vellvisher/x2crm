<?php
$title =  'Edit Newsletter:';

$pieces = explode(", ",$model->editPermissions);
$user = Yii::app()->user->getName();

$this->actionMenu = $this->formatMenu(array(
    array('label'=> 'List Newsletters', 'url'=>array('index')),
    array('label'=> 'Create Newsletter', 'url'=>array('create')),
));

?>

<div class="page-title icon newsletters">
    <h2>
        <span class="no-bold"><?php echo $title; ?></span>
        <?php echo CHtml::encode($model->name); ?>
    </h2>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
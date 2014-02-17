<?php

$this->breadcrumbs=array(
    'Newsletters',
);
$this->actionMenu = $this->formatMenu(array(
    array('label'=>Yii::t('newsletters', 'List Newsletters')),
    array('label'=>Yii::t('newsletters', 'Create Newsletter'), 'url'=>array('create')),
));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('contacts-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="search-form" style="display:none"><!-- search-form -->
    <?php $this->renderPartial('_search',array(
        'model'=>$model,
    )); ?>
</div>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').unbind('click').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('newsletters-grid', {
        data: $(this).serialize()
    });
    return false;
});

",CClientScript::POS_READY);

$this->widget('application.components.X2GridView', array(
    'id'=>'newsletters-grid',
    'title'=>Yii::t('newsletters','Newsletters'),
    'buttons'=>array('advancedSearch','clearFilters','columnSelector'),
    'template'=> '<div class="page-title icon newsletters">{title}{buttons}{filterHint}{summary}</div>{items}{pager}',
    'dataProvider'=>$model->search(),
    // 'enableSorting'=>false,
    // 'model'=>$model,
    'filter'=>$model,
    'modelName'=>'Newsletters',
    'viewName'=>'newsletters',
    'defaultGvSettings'=>array(
        'name' => 253,
        'createdBy' => 76,
        'createDate' => 111,
        'lastUpdated' => 115,
    ),
    'specialColumns'=>array(
        'name' => array(
            'header'=>Yii::t('newsletters','Title'),
            'name'=>'name',
            'value'=>'CHtml::link($data->name,array("view","id"=>$data->id))',
            'type'=>'raw',
        ),
        'type' => array(
            'header'=>Yii::t('newsletters','Type'),
            'name'=>'type',
            'value'=>'$data->parseType()',
            'type'=>'raw',
        ),
        'createdBy' => array(
            'header'=>Yii::t('newsletters','Created By'),
            'name'=>'createdBy',
            'value'=>'User::getUserLinks($data->createdBy,true,true)',
            'type'=>'raw',
        ),
        'updatedBy' => array(
            'header'=>Yii::t('newsletters','Updated By'),
            'name'=>'updatedBy',
            'value'=>'User::getUserLinks($data->updatedBy,true,true)',
            'type'=>'raw',
        ),
    ),
    'excludedColumns' => array(
        'text',
        'type',
        'editPermissions',
    ),
    'enableControls'=>false,
    'fullscreen'=>true,
));

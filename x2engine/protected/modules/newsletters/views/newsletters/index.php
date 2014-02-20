<?php

$this->breadcrumbs=array(
    'Newsletters',
);
$this->actionMenu = $this->formatMenu(array(
    array('label'=> 'List Newsletters'),
    array('label'=> 'Create Newsletter', 'url'=>array('create')),
));

$this->widget('application.components.X2GridView', array(
    'id'=>'newsletters-grid',
    'title'=> 'Newsletters',
    'buttons'=>array('columnSelector'),
    'template'=> '<div class="page-title icon newsletters">{title}{buttons}{summary}</div>{items}{pager}',
    'dataProvider'=>$model->all(),
    'enableSorting'=>true,
    'modelName'=>'Newsletters',
    'viewName'=>'newsletters',
    'defaultGvSettings'=>array(
        'name' => 100,
        'subject' => 150,
        'updatedBy' => 100,
        'dateUpdated' => 100,
        'published' => 100,
    ),
    'specialColumns'=>array(
        'name' => array(
            'header'=> 'Title',
            'name'=>'name',
            'value'=>'CHtml::link($data->name,array("view","id"=>$data->id))',
            'type'=>'raw',
        ),
        'type' => array(
            'header'=> 'Type',
            'name'=>'type',
            'value'=>'$data->parseType()',
            'type'=>'raw',
        ),
        'updatedBy' => array(
            'header'=> 'Updated By',
            'name'=>'updatedBy',
            'value'=>'User::getUserLinks($data->updatedBy,true,true)',
            'type'=>'raw',
        ),
    ),
    'excludedColumns' => array(
        'body',
    ),
    'fullscreen'=>true,
));

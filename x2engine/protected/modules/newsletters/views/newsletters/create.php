<?php
$menuItems = array(
    array('label'=>Yii::t('newsletters', 'List Newsletters'), 'url'=>array('index')),
    array('label'=>Yii::t('newsletters', 'Create Newsletter'))
);

?>
<div class="page-title icon newsletters"><h2>
<?php
    echo Yii::t('newsletters','Create Newsletter');
?>
</h2>
</div>

<?php
$this->actionMenu = $this->formatMenu($menuItems);

echo $this->renderPartial('_form', array('model'=>$model,'users'=>$users));


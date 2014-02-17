<?php
$menuItems = array(
    array('label'=>Yii::t('newsletters','List Newsletters'),'url'=>array('index')),
    array('label'=>Yii::t('newsletters','Create Newsletter'),'url'=>array('create')),
);

?>
<div class="page-title icon newsletters"><h2><?php
    unset($menuItems[1]['url']);
    echo Yii::t('newsletters','Create Newsletter');
    ?></h2>
</div>

<?php
$this->actionMenu = $this->formatMenu($menuItems);

echo $this->renderPartial('_form', array('model'=>$model,'users'=>$users));


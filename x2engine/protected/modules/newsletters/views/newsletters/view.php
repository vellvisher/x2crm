<?php
$this->setPageTitle($model->name);
$themeUrl = Yii::app()->theme->getBaseUrl();

$this->actionMenu = $this->formatMenu(array(
    array('label'=>Yii::t('newsletters','List Newsletters'), 'url'=>array('index')),
    array('label'=>Yii::t('newsletters','Create Newsletter'), 'url'=>array('create')),
));
if(Yii::app()->params->isAdmin || $user==$model->createdBy)
    $this->actionMenu[] = array('label'=>Yii::t('newsletters','Delete Newsletter'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('newsletters','Are you sure you want to delete this item?')));

Yii::app()->getClientScript()->registerScript('newsletterIframeAutoExpand','
$("#newsletterIframe").load(function() {
    $(this).height($(this).contents().height());
});
$(window).resize(function() {
    $("#newsletterIframe").height($("#newsletterIframe").height(650).contents().height());
});
',CClientScript::POS_READY);
?>
<div class="page-title icon newsletters">
    <h2>
        <span class="no-bold"><?php echo Yii::t('newsletters','Newsletter:'); ?></span>
        <?php echo $model->name; ?>
    </h2>

    <?php
    $perm=$model->editPermissions;
    $pieces=explode(", ",$perm);
    // if(Yii::app()->params->isAdmin || $user==$model->createdBy)
    //     $this->actionMenu[] = array('label'=>Yii::t('newsletters','Delete Newsletter'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('newsletters','Are you sure you want to delete this item?')));

    if((Yii::app()->user->checkAccess('NewslettersAdmin') || Yii::app()->user->getName()==$model->createdBy || array_search(Yii::app()->user->getName(),$pieces)!==false || Yii::app()->user->getName()==$perm))
        echo CHtml::link('<span></span>',array('/newsletters/newsletters/edit','id'=>$model->id),array('class'=>'x2-button x2-hint icon edit right','title'=>Yii::t('newsletters','Edit')));
        echo CHtml::link('<span></span>',array('/newsletters/newsletters/create','duplicate'=>$model->id),array('class'=>'x2-button icon copy right x2-hint','title'=>Yii::t('newsletters','Make a copy')));
    echo "<br>\n";
    ?>
</div>
<iframe src="<?php echo $this->createUrl('/newsletters/newsletters/fullView/'.$model->id); ?>" id="newsletterIframe" frameBorder="0" scrolling="no" height="650" width="100%" style="background:#fff;overflow:hidden;"></iframe>
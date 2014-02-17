<?php
$this->setPageTitle($model->name);
$themeUrl = Yii::app()->theme->getBaseUrl();
Yii::app()->getClientScript()->registerScript('newsletterIframeAutoExpand','
$("#newsletterIframe").load(function() {
    $(this).height($(this).contents().height());
});
$(window).resize(function() {
    $("#newsletterIframe").height($("#newsletterIframe").height(650).contents().height());
});
',CClientScript::POS_READY);
?>
<div class="page-title icon newsletters"><h2><span class="no-bold"><?php echo Yii::t('newsletters','Newsletter:'); ?></span> <?php echo $model->name; ?></h2>

<?php
$perm=$model->editPermissions;
$pieces=explode(", ",$perm);
if(Yii::app()->user->checkAccess('NewslettersUpdate') && (Yii::app()->user->checkAccess('NewslettersAdmin') || Yii::app()->user->getName()==$model->createdBy || array_search(Yii::app()->user->getName(),$pieces)!==false || Yii::app()->user->getName()==$perm))
    echo CHtml::link('<span></span>',array('/newsletters/newsletters/update','id'=>$model->id),array('class'=>'x2-button x2-hint icon edit right','title'=>Yii::t('newsletters','Edit')));
    echo CHtml::link('<span></span>',array('/newsletters/newsletters/create','duplicate'=>$model->id),array('class'=>'x2-button icon copy right x2-hint','title'=>Yii::t('newsletters','Make a copy')));
echo "<br>\n";
?>
</div>
<iframe src="<?php echo $this->createUrl('/newsletters/newsletters/fullView/'.$model->id); ?>" id="docIframe" frameBorder="0" scrolling="no" height="650" width="100%" style="background:#fff;overflow:hidden;"></iframe>
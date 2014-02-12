<?php
/* @var $this DefaultController */
$menuItems = array(
	array('label'=>Yii::t('chatRoom','Chat Room List'), 'url' => array('index')),
	array('label'=>Yii::t('chatRoom','Create'), 'url'=>array('createChatRoom')),
);
$this->actionMenu = $this->formatMenu($menuItems);
echo "here are the list of chat rooms";
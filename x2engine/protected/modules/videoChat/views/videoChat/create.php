<?php
$menuItems = array(
	array('label'=>Yii::t('chatRoom','Chat Room List'), 'url' => array('index')),
	array('label'=>Yii::t('chatRoom','Create'), 'url'=>array('createChatRoom')),
);
$this->actionMenu = $this->formatMenu($menuItems);
echo "create chat room here";
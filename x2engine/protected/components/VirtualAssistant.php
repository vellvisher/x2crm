<?php
Yii::import('zii.widgets.CPortlet');


/**
 * Widget class for displaying the "Tour" menu
 * 
 * @package X2CRM.components 
 */
class VirtualAssistant extends CPortlet {

	public $currentAction = '';

	public function init() {
		$this->title=Yii::t('app','Virtual Assistant');
		parent::init();
	}

	protected function renderContent() {
		echo "<a id='start-tour' href= '#'>Change Your Calendar permissions</a>";
	}
}
?>
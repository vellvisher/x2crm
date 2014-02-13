<?php
/**
 * Class for the media library box widget.
 *
 * @package X2CRM.components
 */
class Chat extends X2Widget {

    public $visibility;
    public $drive = 0;

    public function init(){
        $this->drive = Yii::app()->params->profile->mediaWidgetDrive;
        // Yii::app()->clientScript->registerCoreScript('jquery.ui');
        parent::init();
    }

    public function run(){
        $this->render('chat', array()); //array(
    }

}

<?php
/**
 * Displays a particular model.
 * @param integer $id the ID of the model to be displayed
 * @package X2CRM.modules.newsletters.controllers
 */
class FullViewAction extends CAction {

    public function run($id,$json=0) {

        $model = $this->getController()->loadModel($id);

        echo $json ? CJSON::encode(array('body'=>$model->body,'subject'=>$model->subject)) : $model->body;
    }
}

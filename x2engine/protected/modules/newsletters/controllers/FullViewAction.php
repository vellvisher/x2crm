<?php
/**
 * Displays a particular model.
 * @param integer $id the ID of the model to be displayed
 * @package X2CRM.modules.newsletters.controllers
 */
class FullViewAction extends CAction {

    public function run($id) {
        echo $this->getController()->loadModel($id)->body;
    }
}

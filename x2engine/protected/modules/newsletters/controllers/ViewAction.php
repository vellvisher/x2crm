<?php
/**
 * Displays a particular model.
 * @param integer $id the ID of the model to be displayed
 * @package X2CRM.modules.newsletters.controllers
 */
class ViewAction extends CAction {

    public function run($id) {
        $controller = $this->getController();
        $model = $controller->loadModel($id);
        if (!isset($model))
            $this->redirect(array('newsletters/index'));

        $controller->render('view', array(
            'model' => $model,
        ));
    }

}
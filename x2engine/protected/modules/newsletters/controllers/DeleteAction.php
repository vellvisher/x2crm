<?php
/**
 * Deletes a particular model.
 * If deletion is successful, the browser will be redirected to the 'admin' page.
 * @param integer $id the ID of the model to be deleted
 * @package X2CRM.modules.newsletters.controllers
 */
class DeleteAction extends CAction {
    public function run($id) {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $controller = $this->getController();
            $model = $controller->loadModel($id);
            $controller->cleanUpTags($model);
            $model->delete();
            $controller->redirect(array('index'));
        } else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}

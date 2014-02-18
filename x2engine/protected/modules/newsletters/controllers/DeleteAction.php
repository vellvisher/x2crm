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

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
}

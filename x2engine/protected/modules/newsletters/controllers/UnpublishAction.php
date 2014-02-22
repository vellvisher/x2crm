<?php
/**
 * Updates a particular model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id the ID of the model to be updated
 * @package X2CRM.modules.newsletters.controllers
 */
class UnpublishAction extends CAction {

    public function run($id) {
        if(Yii::app()->request->isPostRequest) {
            // we only allow unpublishing via POST request
            $controller = $this->getController();
            $model = $controller->loadModel($id);
            $model->published = 0;
            $model->startDate = null;
            $model->endDate = null;
            if ($model->save()) {
                $this->removeUserNotifications($model->id);
            }
            $controller->redirect(array('index'));
        } else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    private function removeUserNotifications($id) {
        $notifications = new CActiveDataProvider('Notification', array(
            'criteria' => array(
                'condition' => "modelId=$id and type='newsletter_publish'",
            )
        ));
        foreach ($notifications->data as $notification) {
            $notification->delete();
        }
    }
}
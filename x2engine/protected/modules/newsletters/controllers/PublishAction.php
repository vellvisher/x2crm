<?php
/**
 * Updates a particular model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id the ID of the model to be updated
 * @package X2CRM.modules.newsletters.controllers
 */
class PublishAction extends CAction {

    public function run($id) {
        if(!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
            $controller = $this->getController();
            $model = $controller->loadModel($id);
            $model->startDate = strtotime($_POST['startDate']);
            $model->endDate = strtotime($_POST['endDate']);
            $model->type = $_POST['type'];
            $model->published = '1';
            if ($model->save())
                $this->notifyUsers($model);
            $controller->redirect(array('view','id'=>$model->id));
        } else throw new CHttpException(400,'Invalid request. Please fill in all the fields.');
    }

    private function notifyUsers($model) {
        $users = new CActiveDataProvider('User', array(
            'criteria' => array(
                'condition' => 'status=1',
            )
        ));
        foreach ($users->data as $user) {
            $notification = new Notification;
            $notification->modelType = 'Newsletters';
            $notification->createdBy = Yii::app()->user->getName();
            $notification->user = $user->username;
            $notification->modelId = $model->id;
            $notification->createDate = $model->startDate;
            $notification->type = 'newsletter_publish';
            $notification->save();
        }
    }
}
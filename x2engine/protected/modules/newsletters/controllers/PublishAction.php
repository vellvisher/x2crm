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
            if ($model->startDate > $model->endDate) {
                throw new CHttpException(400,'Invalid request. Start date should be before the end date.');
            }
            $model->type = $_POST['type'];
            $model->published = '1';
            if ($model->save())
                $this->notifyUsers($model);
            $controller->redirect(array('view','id'=>$model->id));
        } else throw new CHttpException(400,'Invalid request. Please fill in all the fields.');
    }

    private function notifyUsers($model) {
        $users = Yii::app()->db->createCommand('select * from x2_users where status=1')->queryAll();
        foreach ($users as $user) {
            for ($time = $model->startDate; $time <= $model->endDate;) {
                $notification = new Notification;
                $notification->modelType = 'Newsletters';
                $notification->createdBy = Yii::app()->user->getName();
                $notification->user = $user['username'];
                $notification->modelId = $model->id;
                $notification->createDate = $time;
                $notification->type = 'newsletter_publish';
                $notification->save();
                switch ($model->type) {
                    case NewsletterType::Daily:
                        $time = strtotime('+1 days', $time);
                        break;
                    case NewsletterType::Weekly:
                        $time = strtotime('+1 weeks', $time);
                        break;
                    case NewsletterType::Monthly:
                        $time = strtotime('+1 months', $time);
                        break;
                    default:
                        //Should not reach here
                        throw new CHttpException(400, 'Invalid type');
                        break;
                }
            }
        }
    }
}
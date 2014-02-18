<?php
/**
 * Updates a particular model.
 * If update is successful, the browser will be redirected to the 'view' page.
 * @param integer $id the ID of the model to be updated
 * @package X2CRM.modules.newsletters.controllers
 */
class EditAction extends CAction {

    public function run($id) {
        $controller = $this->getController();
        $model = $controller->loadModel($id);
        $perm = $model->editPermissions;
        $pieces = explode(', ',$perm);
        if(Yii::app()->user->checkAccess('NewslettersAdmin') ||
            Yii::app()->user->getName()==$model->createdBy ||
            array_search(Yii::app()->user->getName(),$pieces) !== false ||
            Yii::app()->user->getName()==$perm) {
            if(isset($_POST['Newsletters'])) {
                $model->attributes = $_POST['Newsletters'];
                $model->visibility = $_POST['Newsletters']['visibility'];
                if($model->save()) {
                    $event = new Events;
                    $event->associationType='Newsletters';
                    $event->associationId=$model->id;
                    $event->type='newsletter_edit';
                    $event->user=Yii::app()->user->getName();
                    $event->visibility=$model->visibility;
                    $event->save();
                    $controller->redirect(array('edit','id'=>$model->id,'saved'=>true, 'time'=>time()));
                }
            }

            $controller->render('edit',array(
                'model'=>$model,
            ));
        } else {
            $controller->redirect(array('view','id'=>$id));
        }
    }
}
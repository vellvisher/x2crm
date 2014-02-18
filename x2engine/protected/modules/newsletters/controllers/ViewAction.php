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
        if(isset($model)){
            $permissions=explode(", ",$model->editPermissions);
            if(in_array(Yii::app()->user->getName(),$permissions))
                $editFlag=true;
            else
                $editFlag=false;
        }
        //echo $model->visibility;exit;
        if (!isset($model) ||
               !(($model->visibility==1 ||
                ($model->visibility==0 && $model->createdBy==Yii::app()->user->getName())) ||
                Yii::app()->params->isAdmin|| $editFlag))
            $this->redirect(array('newsletters/index'));

        $controller->render('view', array(
            'model' => $model,
        ));
    }

}
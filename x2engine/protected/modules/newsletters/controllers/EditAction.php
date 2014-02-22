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

        $controller->performAjaxValidation($model);

        if (isset($_POST['Newsletters'])) {
            $model->attributes  = $_POST['Newsletters'];
            $model->published   = 0;
            $model->updatedBy   = Yii::app()->user->getName();
            $model->dateUpdated  = time();
            if($model->save())
                $controller->redirect(array('view','id'=>$model->id));
        }

        $controller->render('edit',array(
            'model'=>$model,
        ));
    }
}
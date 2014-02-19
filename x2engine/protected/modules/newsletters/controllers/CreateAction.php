<?php
/**
 * Creates a new newsletter.
 * If creation is successful, the browser will be redirected to the 'view' page.
 * @package X2CRM.modules.newsletters.controllers
 */
class CreateAction extends CAction {

    public function run($duplicate = false) {
        $controller = $this->getController();
        $model = new Newsletters;

        if($duplicate) {
            $copiedModel = $controller->loadModel($duplicate);
            if(!is_null($copiedModel)) {
                foreach($copiedModel->attributes as $name=>$value)
                    if($name != 'id')
                        $model->$name = $value;
            }
            $model->name .= ' (copy)';
        }

        $controller->performAjaxValidation($model);

        if (isset($_POST['Newsletters'])) {
            $model->attributes  = $_POST['Newsletters'];
            $model->published   = 0;
            $model->updatedBy   = Yii::app()->user->getName();
            $model->dateUpdated  = time();
            if($model->save())
                $controller->redirect(array('view','id'=>$model->id));
        }

        $controller->render('create',array(
            'model'=>$model,
        ));
    }
}
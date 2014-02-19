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

        $this->performAjaxValidation($model);

        if (isset($_POST['Newsletters'])) {
            $model->attributes=$_POST['Newsletters'];
            $model->published=$_POST['Newsletters']['published'];
            $model->updatedBy = Yii::app()->user->getName();
            $model->updateDate = time();
            if($model->save())
                $controller->redirect(array('view','id'=>$model->id));
        }

        $controller->render('create',array(
            'model'=>$model,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if(isset($_POST['ajax']) && $_POST['ajax']==='newsletters-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
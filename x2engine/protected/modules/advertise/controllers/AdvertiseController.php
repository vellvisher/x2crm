<?php
/**
 * @package X2CRM.modules.advertise.controllers
 */
class AdvertiseController extends x2base {

    public $modelClass='Advertise';

    public function actionIndex() {
        $model = new Advertise;
        if (isset($_POST['Advertise'])) {
            $model->attributes = $_POST['Advertise'];
            if (empty($model->name) || empty($model->phone) || empty($model->address)
                || empty($model->email) || empty($model->url))
                throw new CHttpException('400','Please fill in all the fields');
            $model->user = Yii::app()->user->getName();
            $model->save();
            $this->redirect(array('/'));
        }
        $this->render('create', array('model'=>$model, 'budgets'=>$model->budgets));
    }

    public function actionDeleteAll() {
        if (Yii::app()->params->isAdmin) {
            Advertise::model()->deleteAll();
            $this->redirect(array('/'));
        } else
            throw new CHttpException('400', 'You are not authorized for this action.');
    }

    public function loadModel($id) {
      return Advertise::model()->findByPk((int)$id);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',  // allow only authenticated users
                'actions'=>array('index','deleteAll'),
                'users'=>array('@'),
            ),
            array('deny',  // deny the rest
                'users'=>array('*'),
            ),
        );
    }
}
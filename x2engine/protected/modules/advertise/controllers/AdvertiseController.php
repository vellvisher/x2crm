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
            $model->user = Yii::app()->user->getName();
            $model->save();
            $this->redirect(array('/'));
        }
        $this->render('create', array('model'=>$model, 'budgets'=>$model->budgets));
    }

    public function loadModel($id) {
      return Advertise::model()->findByPk((int)$id);
    }

    /**
     * Install the access control filter to every action
     */
    public function filters() {
        return array('accessControl');
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',  // allow only authenticated users
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array('deny',  // deny the rest
                'users'=>array('*'),
            ),
        );
    }

}
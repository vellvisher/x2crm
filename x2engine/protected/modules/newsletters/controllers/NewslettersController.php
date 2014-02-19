<?php
/**
 * @package X2CRM.modules.newsletters.controllers
 */
class NewslettersController extends x2base {

    public $modelClass='Newsletters';

    public function actions() {
        return array(
            'index'     =>  'application.modules.newsletters.controllers.IndexAction',
            'view'      =>  'application.modules.newsletters.controllers.ViewAction',
            'fullView'  =>  'application.modules.newsletters.controllers.FullViewAction',
            'create'    =>  'application.modules.newsletters.controllers.CreateAction',
            'delete'    =>  'application.modules.newsletters.controllers.DeleteAction',
            'edit'      =>  'application.modules.newsletters.controllers.EditAction',
        );
    }

    public function loadModel($id) {
      $model = Newsletters::model()->findByPk((int)$id);
      if($model === null)
        return null;
      return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    public function performAjaxValidation($model) {
        if(isset($_POST['ajax']) && $_POST['ajax']==='newsletters-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    // public function accessRules() {
    //     return array(
    //         array('allow',
    //             'users'=>array('*'),
    //         ),
    //         array('allow', // allow authenticated user to perform 'create' and 'update' actions
    //             'actions'=>array('index','view','create','createEmail','update','exportToHtml','changePermissions', 'delete', 'getItems', 'getItem'),
    //             'users'=>array('@'),
    //         ),
    //         array('allow', // allow admin user to perform 'admin' and 'delete' actions
    //             'actions'=>array('admin'),
    //             'users'=>array('admin'),
    //         ),
    //         array('deny',  // deny all users
    //             'users'=>array('*'),
    //         ),
    //     );
    // }

}
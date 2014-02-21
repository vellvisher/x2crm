<?php
/**
 * @package X2CRM.modules.newsletters.controllers
 */
class NewslettersController extends x2base {

    public $modelClass='Newsletters';

    public function actions() {
        Yii::app()->cache->flush();

        $this->authorize();
        return array(
            'index'     =>  'application.modules.newsletters.controllers.IndexAction',
            'view'      =>  'application.modules.newsletters.controllers.ViewAction',
            'fullView'  =>  'application.modules.newsletters.controllers.FullViewAction',
            'create'    =>  'application.modules.newsletters.controllers.CreateAction',
            'delete'    =>  'application.modules.newsletters.controllers.DeleteAction',
            'edit'      =>  'application.modules.newsletters.controllers.EditAction',
            'publish'   =>  'application.modules.newsletters.controllers.PublishAction',
            'unpublish'   =>  'application.modules.newsletters.controllers.UnpublishAction',
        );
    }

    /**
     * Throw 403 if not admin and does not have market role (role id 1)
     */
    public function authorize() {
        if (!Yii::app()->params->isAdmin)
            if (!in_array('1', Roles::model()->getUserRoles(Yii::app()->user->id)))
                throw new CHttpException(403, 'You do not have access to view this page!');
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
     * Install the access control filter to every action
     */
    public function filters() {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform any action
                'actions'=>array('index','view','create','delete','edit','fullView','publish', 'unpublish'),
                'users'=>array('@'),
            ),
            array('deny',  // deny the rest
                'users'=>array('*'),
            ),
        );
    }

}
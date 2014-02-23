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
            'publish'   =>  'application.modules.newsletters.controllers.PublishAction',
            'unpublish'   =>  'application.modules.newsletters.controllers.UnpublishAction',
        );
    }

    /**
     * Authorize actions
     */
    public function beforeAction($action=null) {
        Yii::app()->timezone = 'Asia/Singapore';
        // Yii::app()->cache->flush();
        $id = Yii::app()->getRequest()->getQuery('id');
        if ($action->id != 'fullView' || !$this->loadModel($id)->published) {
            $this->authorize();
        }
        return $this->PermissionsBehavior->beforeAction($action);
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
      return Newsletters::model()->findByPk((int)$id);
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
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform any action
                'actions'=>array('index','view','create','delete','edit','publish','fullView','unpublish'),
                'users'=>array('@'),
            ),
            array('deny',  // deny the rest
                'users'=>array('*'),
            ),
        );
    }
}
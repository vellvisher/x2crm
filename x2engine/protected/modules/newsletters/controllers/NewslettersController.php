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

    // public function actionAutosave($id) {
    //     $model = $this->loadModel($id);
    //     if(isset($_POST['Docs'])) {
    //         $model->attributes = $_POST['Docs'];
    //         // $model = $this->updateChangeLog($model,'Edited');
    //         if($model->save()) {
    //             echo Yii::t('docs', 'Saved at') . ' ' . Yii::app()->dateFormatter->format(Yii::app()->locale->getTimeFormat('medium'), time());
    //         };
    //     }
    // }

}
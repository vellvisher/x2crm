<?php
/**
 * @package X2CRM.modules.newsletters.controllers
 */
class NewslettersController extends x2base {

    public $modelClass='Newsletters';

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index','view','create','createEmail','update','exportToHtml','changePermissions', 'delete', 'getItems', 'getItem'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionGetItems(){
        $sql = 'SELECT id, name as value FROM x2_newsletters WHERE name LIKE :qterm ORDER BY name ASC';
        $command = Yii::app()->db->createCommand($sql);

        //CHANGE
        $qterm = '%'.$_GET['term'].'%';
        $command->bindParam(":qterm", $qterm, PDO::PARAM_STR);
        $result = $command->queryAll();
        echo CJSON::encode($result);
    }

    public function actionGetItem($id) {
        $model = $this->loadModel($id);
        if((($model->visibility==1 ||
            ($model->visibility==0 && $model->createdBy==Yii::app()->user->getName()))
            || Yii::app()->params->isAdmin)){
            echo $model->text;
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = CActiveRecord::model('Newsletters')->findByPk($id);
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

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionFullView($id,$json=0) {

        $model = $this->loadModel($id);

        echo $json ? CJSON::encode(array('body'=>$model->text,'subject'=>$model->subject)) : $model->text;
    }

    /**
     * Creates a new doc.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($duplicate = false) {
        $users = User::getNames();
        unset($users['Anyone']);
        unset($users['admin']);
        unset($users[Yii::app()->user->getName()]);
        $model = new Newsletters;

        if($duplicate) {
            $copiedModel = Newsletters::model()->findByPk($duplicate);
            if(!empty($copiedModel)) {
                foreach($copiedModel->attributes as $name=>$value)
                    if($name != 'id')
                        $model->$name = $value;
            }
            $model->name .= ' ('.Yii::t('newsletters','copy').')';
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Newsletters'])) {
            $temp = $model->attributes;
            $model->attributes=$_POST['Newsletters'];
            $model->visibility=$_POST['Newsletters']['visibility'];

            $arr = $model->editPermissions;
            if(isset($arr))
                if(is_array($arr))
                    $model->editPermissions = Accounts::parseUsers($arr);

            $model->createdBy = Yii::app()->user->getName();
            $model->createDate = time();
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $this->render('create',array(
            'model'=>$model,
            'users'=>$users,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdit($id) {
        $model = $this->loadModel($id);
        $perm = $model->editPermissions;
        $pieces = explode(', ',$perm);
        if(Yii::app()->user->checkAccess('NewslettersAdmin') || Yii::app()->user->getName()==$model->createdBy || array_search(Yii::app()->user->getName(),$pieces)!==false || Yii::app()->user->getName()==$perm) {
            if(isset($_POST['Newsletters'])) {
                $model->attributes = $_POST['Newsletters'];
                $model->visibility = $_POST['Newsletters']['visibility'];
                if($model->save()) {
                    $event = new Events;
                    $event->associationType='Newsletters';
                    $event->associationId=$model->id;
                    $event->type='newsletter_edit';
                    $event->user=Yii::app()->user->getName();
                    $event->visibility=$model->visibility;
                    $event->save();
                    $this->redirect(array('edit','id'=>$model->id,'saved'=>true, 'time'=>time()));
                }
            }

            $this->render('edit',array(
                'model'=>$model,
            ));
        } else {
            $this->redirect(array('view','id'=>$id));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if(Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            $this->cleanUpTags($model);
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Newsletters('search');

        $attachments=new CActiveDataProvider('Media',array(
            'criteria'=>array(
            'order'=>'createDate DESC',
            'condition'=>'associationType="newsletters"'
        )));

        $this->render('index', array(
            'model' => $model,
            'attachments' => $attachments,
        ));
    }

    /**
     * WHAT IS THIS???
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    // protected function performAjaxValidation($model) {
    //     if(isset($_POST['ajax']) && $_POST['ajax']==='docs-form') {
    //         echo CActiveForm::validate($model);
    //         Yii::app()->end();
    //     }
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
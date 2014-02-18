<?php
/**
 * Creates a new doc.
 * If creation is successful, the browser will be redirected to the 'view' page.
 * @package X2CRM.modules.newsletters.controllers
 */
class CreateAction extends CAction {

    public function run($duplicate = false) {
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

        $this->getController()->render('create',array(
            'model'=>$model,
            'users'=>$users,
        ));
    }

}
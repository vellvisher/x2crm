<?php

class EditorController extends x2base
{
	public function actionIndex() {
        $fullName = Yii::app()->params->profile->fullName;

        $users = Yii::app()->db->createCommand()
            ->select('fullName, username')
            ->where('username!=:username', array(':username' => Yii::app()->user->name))
            ->from('x2_profile')
            ->queryAll();
        $all_users = array();
        foreach($users as $user) {
            $all_users[] =array('label'=>$user['fullName'], 'value'=>$user['username']);
        }

        $this->render('index', array('fullName' => $fullName,
            'all_users' => json_encode($all_users)));

	}

    public function actionJoin() {
    }

    public function actionInvite() {
    }
}
?>

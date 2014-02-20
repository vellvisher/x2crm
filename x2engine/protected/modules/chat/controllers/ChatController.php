<?php

class ChatController extends x2base
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
        $fullName = Yii::app()->params->profile->fullName; 
        $user_id = Yii::app()->params->profile->id; 

        $chatroom_id = $_POST['chatroom_id'];
        // TODO: Sanitize input
        $users = Yii::app()->db->createCommand()
            ->select('fullName, username')
            ->where('username!=:username', array(':username' => Yii::app()->user->name))
            ->from('x2_profile')
            ->queryAll();

        ChatroomInvite::model()->deleteAllByAttributes(array('chatroom_id' => $chatroom_id,
            'user_id' => $user_id));

        $this->render('join', array('chatroom_id' => $chatroom_id,
            'fullName' => $fullName));
    }

	public function actionInvite() {
        $poster_user_id = Yii::app()->params->profile->id;
        // if (!Yii::app()->user->checkAccess('create chatroom_invite')) {
        //     // not allowed... .
        //     throw new CHttpException(401);
        // }
        // TODO:Check output of below line
        #$user = User::model()->findByPk(Yii::app()->user->getId());
        $invite = new ChatroomInvite('insert');
        if (isset($_POST['chatroom_id']) && isset($_POST['username'])) {
            // TODO: Need to sanitize input
            $chatroom_id = $_POST['chatroom_id'];
            $username = $_POST['username'];

            $user_id_array = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('x2_users')
                    ->where('username=:username', array(':username'=>$username))
                    ->queryRow();
            if (count($user_id_array) != 1 || !isset($user_id_array['id'])) {
                Yii::log('Could not get user id', 'error');
                throw new CHttpException(400);
            }
            $user_id = $user_id_array['id'];

            $invite->chatroom_id=$chatroom_id;
            $invite->user_id=$user_id;
            $invite->poster_id=$poster_user_id;

            $trans = Yii::app()->db->beginTransaction();

            try {
                $invite->save();
                $trans->commit();
                echo 'Done';
            } catch (Exception $e) {
                $trans->rollback();
                Yii::log(e, 'error');
                throw new CHttpException(400);
            }
        }
	}
}
?>

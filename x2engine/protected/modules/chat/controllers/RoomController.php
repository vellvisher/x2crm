<?php

class RoomController extends Controller
{
	public function actionIndex() {
		$this->render('index');
	}

    public function actionJoin() {
        // $room = _POST['chatroom_id'];
        // TODO: Sanitize input

		$this->render('join');
    }

	public function actionInvite() {
        $poster_username = Yii::app()->params->profile->username;
        // if (!Yii::app()->user->checkAccess('create chatroom_invite')) {
        //     // not allowed... .
        //     throw new CHttpException(401);
        // }
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
                throw new CHttpException(400);
            }
            $user_id = $user_id_array['id'];

            // Get Poster ID
            $user_id_array = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('x2_users')
                    ->where('username=:username', array(':username'=>$poster_username))
                    ->queryRow();
            if (count($user_id_array) != 1 || !isset($user_id_array['id'])) {
                throw new CHttpException(400);
            }
            $poster_user_id = $user_id_array['id'];
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
                throw new CHttpException(400);
            }
        }
	}
}
?>

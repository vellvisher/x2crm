<?php
/**
 * Class for the media library box widget.
 *
 * @package X2CRM.components
 */
class Ymal extends X2Widget {

    public $visibility;
    public $drive = 0;

    public function init(){
        $this->drive = Yii::app()->params->profile->mediaWidgetDrive;
        // Yii::app()->clientScript->registerCoreScript('jquery.ui');
        parent::init();
    }

    public function run(){
        $username = Yii::app()->params->profile->username;
        $fullName = Yii::app()->params->profile->fullName;

        // Get current user's id
        $user_id_array = Yii::app()->db->createCommand()
            ->select('id')
            ->from('x2_users')
            ->where('username=:username', array(':username'=>$username))
            ->queryRow();
        if (count($user_id_array) != 1 || !isset($user_id_array['id'])) {
            throw new CHttpException(400);
        }

        $invite_url = Yii::app()->baseUrl.'/index.php/chat/chat/index';
        $join_url = Yii::app()->baseUrl.'/index.php/chat/chat/join';

        $user_id = $user_id_array['id'];

        $allUsers = Yii::app()->db->createCommand()
            ->select('fullName, username, id')
            ->where('username!=:username', array(':username' => Yii::app()->user->name))
            ->from('x2_profile')
            ->queryAll();
        $users = array();
        foreach($allUsers as $user) {
            $chatInvites = Yii::app()->db->createCommand()
                ->select('chatroom_id')
                ->where('poster_id=:poster_id AND user_id=:user_id', array(':user_id' => $user_id, ':poster_id'=>$user['id']))
                ->from('chatroom_invite')
                ->queryAll();
            if ($chatInvites) {
                $users[] = array('fullName' => $user['fullName'],
                                'invites' => $chatInvites);
            }
        }

        $this->render('chat', array('fullName' => $fullName,
            'username' => $username, 'invite_url' => $invite_url,
            'users' => $users, 'join_url' => $join_url));
    }

}

<?php
/**
 * Class for the Chat widget.
 *
 * @package X2CRM.components
 */
class Chat extends X2Widget {

    public $visibility;

    public function init(){
        parent::init();
    }

    public function run(){
        $username = Yii::app()->params->profile->username;
        $fullName = Yii::app()->params->profile->fullName;
        $user_id = Yii::app()->params->profile->id;

        $invite_url = Yii::app()->baseUrl.'/index.php/chat/chat/index';
        $join_url = Yii::app()->baseUrl.'/index.php/chat/chat/join';

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

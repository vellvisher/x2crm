<?php
/**
 * Class for the media library box widget.
 *
 * @package X2CRM.components
 */
class Ymal extends X2Widget {

    public $visibility;

    public function init(){
        parent::init();
    }

    public function run(){
        $username = Yii::app()->params->profile->username;
        $fullName = Yii::app()->params->profile->fullName;
        $user_id = Yii::app()->params->profile->id;

        $allUsers = Yii::app()->db->createCommand()
            ->select('fullName, username, id')
            ->where('username!=:username', array(':username' => Yii::app()->user->name))
            ->from('x2_profile')
            ->queryAll();

        $allUsersIdF = array();
        $usernameIdMap = array();
        foreach($allUsers as $user) {
            $allUsersIdF[$user['id']] = 0;
            $usernameIdMap[$user['username']] = $user['id'];
        }


        $allPosts = Yii::app()->db->createCommand()
            ->select('associationId, user')
            ->where('(type = "comment" OR type = "feed") AND (associationType is not NULL) AND (user=:username OR associationId=:user_id)',
                array(':username' => $username, ':user_id' => $user_id))
            ->from('x2_events')
            ->queryAll();

        foreach($allPosts as $post) {
            if ($post['associationId'] != $user_id) {
                $allUsersIdF[$post['associationId']]++;
            }
            if ($post['user'] != $username) {
                $allUsersIdF[$usernameIdMap[$post['user']]]++;
            }
        }

        arsort($allUsersIdF);
        $topUsersIdF = array_slice($allUsersIdF, 0, 5, true);

        $topPosts = array();
        $topPostsText = array();
        foreach($topUsersIdF as $topUserId => $topUserIdVal) {
            $topUsername = Yii::app()->db->createCommand()
                ->select('username, id')
                ->where('id=:id', array(':id'=>$topUserId))
                ->from('x2_profile')
                ->queryAll();

            $user = $topUsername[0];

            $allPosts = Yii::app()->db->createCommand()
                ->select('associationId, user, text, id')
                ->where('user=:username2 OR associationId=:userid2 AND (user!=:username AND associationId!=:user_id) AND visibility=1',
                    array(':username' => $username, ':user_id' => $user_id, ':username2' => $user['username'], ':userid2' => $user['id']))
                ->from('x2_events')
                ->order('timestamp desc')
                ->queryAll();
            $allPosts = array_slice($allPosts, 0, 3, true);
            foreach ($allPosts as $post) {
                $topPosts[] = $post['id'];
            }
        }
        array_unique($topPosts);
        $events = X2Model::model('Events')->findAllByPk($topPosts, array('order' => 'timestamp desc'));
        foreach ($events as $event) {
            $topPostsText[] = $event->getText();
        }
        $this->render('ymal', array('fullName' => $fullName,
            'username' => $username,
            'topPostsText' => $topPostsText));
    }

}
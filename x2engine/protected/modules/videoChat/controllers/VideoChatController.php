<?php

class VideoChatController extends x2base
{
	public $modelClass = 'ChatRoom';
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionCreateChatRoom() 
	{
		$this->render('create');
	}
	public function actionView($id) {
		// echo (ChatRoom);
		$room=ChatRoom::model()->findByPk($id);
		echo var_dump($room);
	}
}
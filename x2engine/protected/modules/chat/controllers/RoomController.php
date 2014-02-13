<?php

class RoomController extends Controller
{
	public function actionIndex() {
		$this->render('index');
	}

	public function actionInvite() {
		$this->render('invite');
	}
}
?>

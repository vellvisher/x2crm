<?php

Yii::import('application.models.X2Model');

/**
 * This is the model class for table "x2_chatroom".
 *
 * @package X2CRM.modules.videoChat.models
 */
class ChatRoom extends X2Model {
	/**
	 * Returns the static model of the specified AR class.
	 * @return Opportunity the static model class
	 */
	public static function model($className=__CLASS__) { return parent::model($className); }

	/**
	 * @return string the associated database table name
	 */
	public function tableName() { return 'x2_chatroom'; }

	public function behaviors() {
		return array_merge(parent::behaviors(),array(
			'X2LinkableBehavior'=>array(
				'class'=>'X2LinkableBehavior',
				'module'=>'videoChat'
			),
			'ERememberFiltersBehavior' => array(
				'class' => 'application.components.ERememberFiltersBehavior',
				'defaults'=>array(),
				'defaultStickOnClear'=>false
			)
		));
	}

	/**
	 * Formats data for associatedContacts before saving
	 * @return boolean whether or not to save
	 */
	// public function beforeSave() {
	// 	if(isset($this->associatedContacts))
	// 		$this->associatedContacts = self::parseContacts($this->associatedContacts);

	// 	return parent::beforeSave();
	// }

}
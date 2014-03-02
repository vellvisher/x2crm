<?php

/**
 * This is the model class for table "chatroom_invite".
 *
 * The followings are the available columns in table 'chatroom_invite':
 * @property string $chatroom_id
 * @property string $user_id
 * @property string $poster_id
 *
 * The followings are the available model relations:
 * @property X2Users $poster
 * @property X2Users $user
 */
class ChatroomInvite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChatroomInvite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'chatroom_invite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chatroom_id, user_id, poster_id', 'required'),
			array('chatroom_id', 'length', 'max'=>30),
			array('user_id, poster_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('chatroom_id, user_id, poster_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'poster' => array(self::BELONGS_TO, 'X2Users', 'poster_id'),
			'user' => array(self::BELONGS_TO, 'X2Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'chatroom_id' => 'Chatroom',
			'user_id' => 'User',
			'poster_id' => 'Poster',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('chatroom_id',$this->chatroom_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('poster_id',$this->poster_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getJoinHTML() {
		$join_url = Yii::app()->baseUrl.'/index.php/chat/chat/join';
        $html = CHtml::form($join_url, 'post', array('target'=>'_blank'));
		$html.= "<input type ='hidden' name='chatroom_id' value=".$this->chatroom_id."></input>";
		$html.="<input type='submit' value='Join'></input>";
		$html.="</form>";
		return $html;
	}
}

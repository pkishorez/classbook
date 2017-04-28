<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $orig_name
 * @property string $name
 * @property string $gender
 * @property string $dob
 * @property string $password
 * @property string $graphpassword
 * @property integer $first_time_login
 * @property integer $cover_photo_top
 *
 * The followings are the available model relations:
 * @property Chat[] $chats
 * @property Chat[] $chats1
 * @property ChatStats[] $chatStats
 * @property ChatStats[] $chatStats1
 * @property Comments[] $comments
 * @property Comments[] $comments1
 * @property Online $online
 * @property Profile $profile
 * @property Wall[] $walls
 * @property Wall[] $walls1
 * @property Wall[] $walls2
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('first_time_login, cover_photo_top', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>10),
			array('orig_name, name', 'length', 'max'=>100),
			array('gender, password, graphpassword', 'length', 'max'=>45),
			array('dob', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, orig_name, name, gender, dob, password, graphpassword, first_time_login, cover_photo_top', 'safe', 'on'=>'search'),
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
			'chats' => array(self::HAS_MANY, 'Chat', 'too'),
			'chats1' => array(self::HAS_MANY, 'Chat', 'frm'),
			'chatStats' => array(self::HAS_MANY, 'ChatStats', 'frm'),
			'chatStats1' => array(self::HAS_MANY, 'ChatStats', 'too'),
			'comments' => array(self::MANY_MANY, 'Comments', 'comment_likes(user_id, comment_id)'),
			'comments1' => array(self::HAS_MANY, 'Comments', 'owner'),
			'online' => array(self::HAS_ONE, 'Online', 'user_id'),
			'profile' => array(self::HAS_ONE, 'Profile', 'id'),
			'walls' => array(self::HAS_MANY, 'Wall', 'owner'),
			'walls1' => array(self::HAS_MANY, 'Wall', 'posted_on'),
			'walls2' => array(self::MANY_MANY, 'Wall', 'wall_likes(user_id, wall_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orig_name' => 'Orig Name',
			'name' => 'Name',
			'gender' => 'Gender',
			'dob' => 'Dob',
			'password' => 'Password',
			'graphpassword' => 'Graphpassword',
			'first_time_login' => 'First Time Login',
			'cover_photo_top' => 'Cover Photo Top',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('orig_name',$this->orig_name,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('graphpassword',$this->graphpassword,true);
		$criteria->compare('first_time_login',$this->first_time_login);
		$criteria->compare('cover_photo_top',$this->cover_photo_top);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

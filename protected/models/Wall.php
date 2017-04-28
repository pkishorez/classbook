<?php

/**
 * This is the model class for table "wall".
 *
 * The followings are the available columns in table 'wall':
 * @property integer $id
 * @property string $owner
 * @property string $posted_on
 * @property string $message
 * @property integer $images
 * @property string $type
 * @property integer $n_comments
 * @property integer $n_likes
 * @property string $time
 *
 * The followings are the available model relations:
 * @property Comments[] $comments
 * @property User $owner0
 * @property User $postedOn
 * @property User[] $users
 */
class Wall extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wall';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('images, n_comments, n_likes', 'numerical', 'integerOnly'=>true),
			array('owner, posted_on', 'length', 'max'=>10),
			array('type', 'length', 'max'=>20),
			array('message, time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, owner, posted_on, message, images, type, n_comments, n_likes, time', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comments', 'wall_id'),
			'owner0' => array(self::BELONGS_TO, 'User', 'owner'),
			'postedOn' => array(self::BELONGS_TO, 'User', 'posted_on'),
			'users' => array(self::MANY_MANY, 'User', 'wall_likes(wall_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'owner' => 'Owner',
			'posted_on' => 'Posted On',
			'message' => 'Message',
			'images' => 'Images',
			'type' => 'Type',
			'n_comments' => 'N Comments',
			'n_likes' => 'N Likes',
			'time' => 'Time',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('posted_on',$this->posted_on,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('images',$this->images);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('n_comments',$this->n_comments);
		$criteria->compare('n_likes',$this->n_likes);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Wall the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

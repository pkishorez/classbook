<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property integer $wall_id
 * @property string $owner
 * @property string $comment
 * @property integer $has_image
 * @property integer $n_likes
 * @property string $time
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property Wall $wall
 * @property User $owner0
 */
class Comments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wall_id', 'required'),
			array('wall_id, has_image, n_likes', 'numerical', 'integerOnly'=>true),
			array('owner', 'length', 'max'=>45),
			array('comment, time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wall_id, owner, comment, has_image, n_likes, time', 'safe', 'on'=>'search'),
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
			'users' => array(self::MANY_MANY, 'User', 'comment_likes(comment_id, user_id)'),
			'wall' => array(self::BELONGS_TO, 'Wall', 'wall_id'),
			'owner0' => array(self::BELONGS_TO, 'User', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wall_id' => 'Wall',
			'owner' => 'Owner',
			'comment' => 'Comment',
			'has_image' => 'Has Image',
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
		$criteria->compare('wall_id',$this->wall_id);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('has_image',$this->has_image);
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
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

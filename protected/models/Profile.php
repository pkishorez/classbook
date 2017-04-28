<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property string $id
 * @property string $father_name
 * @property string $mother_name
 * @property string $nickname
 * @property string $dob
 * @property string $facebook_id
 * @property string $email
 * @property string $ph_no
 * @property string $fav_actor
 * @property string $fav_movies
 * @property string $fav_dish
 * @property string $fav_place
 * @property string $fav_subject
 * @property string $fav_teacher
 * @property string $fav_color
 * @property string $best_friend
 * @property string $hobbies
 * @property string $quote
 * @property string $ambition
 * @property string $role_model
 *
 * The followings are the available model relations:
 * @property User $id0
 */
class Profile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, nickname', 'required'),
			array('id', 'length', 'max'=>10),
			array('father_name, mother_name, nickname, facebook_id, fav_actor, fav_movies, fav_subject, fav_teacher, ambition, role_model', 'length', 'max'=>100),
			array('email, fav_dish, fav_place, best_friend, quote', 'length', 'max'=>45),
			array('ph_no', 'length', 'max'=>15),
			array('fav_color', 'length', 'max'=>20),
			array('hobbies', 'length', 'max'=>200),
			array('dob', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, father_name, mother_name, nickname, dob, facebook_id, email, ph_no, fav_actor, fav_movies, fav_dish, fav_place, fav_subject, fav_teacher, fav_color, best_friend, hobbies, quote, ambition, role_model', 'safe', 'on'=>'search'),
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
			'id0' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'father_name' => 'Father Name',
			'mother_name' => 'Mother Name',
			'nickname' => 'Nickname',
			'dob' => 'Dob',
			'facebook_id' => 'Facebook',
			'email' => 'Email',
			'ph_no' => 'Ph No',
			'fav_actor' => 'Fav Actor',
			'fav_movies' => 'Fav Movies',
			'fav_dish' => 'Fav Dish',
			'fav_place' => 'Fav Place',
			'fav_subject' => 'Fav Subject',
			'fav_teacher' => 'Fav Teacher',
			'fav_color' => 'Fav Color',
			'best_friend' => 'Best Friend',
			'hobbies' => 'Hobbies',
			'quote' => 'Quote',
			'ambition' => 'Ambition',
			'role_model' => 'Role Model',
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
		$criteria->compare('father_name',$this->father_name,true);
		$criteria->compare('mother_name',$this->mother_name,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('facebook_id',$this->facebook_id,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('ph_no',$this->ph_no,true);
		$criteria->compare('fav_actor',$this->fav_actor,true);
		$criteria->compare('fav_movies',$this->fav_movies,true);
		$criteria->compare('fav_dish',$this->fav_dish,true);
		$criteria->compare('fav_place',$this->fav_place,true);
		$criteria->compare('fav_subject',$this->fav_subject,true);
		$criteria->compare('fav_teacher',$this->fav_teacher,true);
		$criteria->compare('fav_color',$this->fav_color,true);
		$criteria->compare('best_friend',$this->best_friend,true);
		$criteria->compare('hobbies',$this->hobbies,true);
		$criteria->compare('quote',$this->quote,true);
		$criteria->compare('ambition',$this->ambition,true);
		$criteria->compare('role_model',$this->role_model,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

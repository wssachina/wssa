<?php

/**
 * This is the model class for table "user_identity".
 *
 * The followings are the available columns in table 'user_identity':
 * @property string $id
 * @property string $user_id
 * @property integer $identity
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class UserIdentity extends ActiveRecord {
	const IDENTITY_COACH = 1;
	const IDENTITY_JUDGE = 2;

	public static function getAllIdentities() {
		return array(
			self::IDENTITY_COACH=>'教练',
			self::IDENTITY_JUDGE=>'裁判',
		);
	}

	public function getName() {
		$identities = self::getAllIdentities();
		return isset($identities[$this->identity]) ? $identities[$this->identity] : $this->identity;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'user_identity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identity, status', 'numerical', 'integerOnly'=>true),
			array('user_id, create_time, update_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, identity, status, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'identity' => 'Identity',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('identity', $this->identity);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserIdentity the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}

<?php

/**
 * This is the model class for table "invitation_code".
 *
 * The followings are the available columns in table 'invitation_code':
 * @property string $id
 * @property string $code
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class InvitationCode extends ActiveRecord {

	const TYPE_ONE_TIME = 0;
	const TYPE_PERMENENT = 1;

	const STATUS_NORMAL = 0;
	const STATUS_USED = 1;

	protected function beforeValidate() {
		if ($this->isNewRecord) {
			$this->generateCode();
		}
		return parent::beforeValidate();
	}

	public function isOneTime() {
		return $this->type == self::TYPE_ONE_TIME;
	}

	public function generateCode($length = 6) {
		$str = '23456789QWERTYUPASDFGHJKLZXCVBNM';
		$code = '';
		for ($i = 0; $i < $length; $i++) {
			$code .= $str{mt_rand(0, strlen($str) - 1)};
		}
		$this->code = $code;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'invitation_code';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			['code', 'required'],
			['code', 'unique'],
			['status', 'numerical', 'integerOnly'=>true],
			['code', 'length', 'max'=>10],
			['create_time, update_time', 'length', 'max'=>11],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, status, create_time, update_time', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('code', $this->code, true);
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
	 * @return InvitationCode the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}

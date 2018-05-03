<?php

/**
 * This is the model class for table "club".
 *
 * The followings are the available columns in table 'club':
 * @property string $id
 * @property string $province_id
 * @property string $city_id
 * @property string $address
 * @property string $contact_name
 * @property string $phone
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Club extends ActiveRecord {
	const STATUS_HIDE = 0;
	const STATUS_SHOW = 1;
	const STATUS_DELETE = 2;

	public static function getAllStatus() {
		return array(
			self::STATUS_HIDE=>'隐藏',
			self::STATUS_SHOW=>'发布',
			// self::STATUS_DELETE=>'删除',
		);
	}

	public function getStatusText() {
		$status = self::getAllStatus();
		return isset($status[$this->status]) ? $status[$this->status] : $this->status;
	}

	public function getOperationButton() {
		$buttons = array();
		$buttons[] = CHtml::link('编辑',  array('/board/club/edit',  'id'=>$this->id), array('class'=>'btn btn-xs btn-blue btn-square'));
		if (Yii::app()->user->checkPermission('faq_admin')) {
			switch ($this->status) {
				case self::STATUS_HIDE:
					$buttons[] = CHtml::link('发布',  array('/board/club/show',  'id'=>$this->id), array('class'=>'btn btn-xs btn-green btn-square'));
					break;
				case self::STATUS_SHOW:
					$buttons[] = CHtml::link('隐藏',  array('/board/club/hide',  'id'=>$this->id), array('class'=>'btn btn-xs btn-red btn-square'));
					break;
			}
		}
		return implode(' ',  $buttons);
	}

	public function getCityInfo() {
		return in_array($this->province_id, [215, 525, 567, 642]) ? $this->province->name_zh : $this->city->name_zh;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'club';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, province_id, city_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('province_id, city_id, create_time, update_time', 'length', 'max'=>11),
			array('address, contact_name, phone', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, province_id, city_id, address, contact_name, phone, status, create_time, update_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'province'=>[self::BELONGS_TO, 'Region', 'province_id'],
			'city'=>[self::BELONGS_TO, 'Region', 'city_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => '俱乐部名称',
			'province_id' => '省份',
			'province' => '省份',
			'city_id' => '城市',
			'address' => '地址',
			'contact_name' => '负责人',
			'phone' => '电话号',
			'status' => '状态',
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

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('province_id', $this->province_id);
		$criteria->compare('city_id', $this->city_id);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('contact_name', $this->contact_name, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time);
		$criteria->compare('update_time', $this->update_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>[
				'defaultOrder'=>'province_id, city_id, name',
			],
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Club the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}

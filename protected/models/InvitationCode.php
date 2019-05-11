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

	public $number;

	protected function beforeValidate() {
		if (!$this->code) {
			$this->generateCode();
		}
		return parent::beforeValidate();
	}

	public static function getTypes() {
		return array(
			self::TYPE_ONE_TIME=>'单次使用',
			self::TYPE_PERMENENT=>'无限制使用',
		);
	}

	public static function getAllStatus() {
		return array(
			self::STATUS_NORMAL=>'未使用',
			self::STATUS_USED=>'已使用',
		);
	}

	public static function getCreateTimes() {
		$times = Yii::app()->db->createCommand()
			->select(array(
				'create_time',
				'FROM_UNIXTIME(create_time) as time',
				'COUNT(code) AS count',
			))
			->from('invitation_code')
			->group('create_time')
			->order('create_time DESC')
			->queryAll();
		$createTimes = array();
		foreach ($times as $time) {
			$createTimes[$time['create_time']] = $time['time'] . ' (' . $time['count'] . ')';
		}
		return $createTimes;
	}

	public function getOperationButton() {
		$buttons = array();
		switch ($this->status) {
			case self::STATUS_USED:
				$buttons[] = CHtml::link('启用',  array('/board/user/enableCode',  'id'=>$this->id), array('class'=>'btn btn-xs btn-green btn-square'));
				break;
			case self::STATUS_NORMAL:
				$buttons[] = CHtml::link('停用',  array('/board/user/disableCode',  'id'=>$this->id), array('class'=>'btn btn-xs btn-red btn-square'));
				break;
		}
		return implode(' ',  $buttons);
	}

	public function getTypeText() {
		$types = self::getTypes();
		return isset($types[$this->type]) ? $types[$this->type] : $this->type;
	}

	public function getStatusText() {
		$status = self::getAllStatus();
		return isset($status[$this->status]) ? $status[$this->status] : $this->status;
	}

	public function createCode() {
		switch ($this->type) {
			case self::TYPE_ONE_TIME:
				if ($this->number > 10000) {
					$this->addError('number', '请输入不超过10000的数量');
					return false;
				}
				$now = time();
				for ($i = 0; $i < $this->number; $i++) {
					$invitationCode = new InvitationCode();
					$invitationCode->create_time = $now;
					$invitationCode->save();
				}
				return true;
				break;
			case self::TYPE_PERMENENT:
				return $this->save();
		}
	}

	public function exportCode() {
		$filename = array('注册码');
		if ($this->type !== "") {
			$filename[] = $this->getTypeText();
		}
		if ($this->status !== "") {
			$filename[] = $this->getStatusText();
		}
		$criteria = new CDbCriteria;
		$criteria->compare('status', $this->status);
		$criteria->compare('type', $this->type);
		if (is_array($this->create_time)) {
			if (isset($this->create_time[0])) {
				$time = strtotime($this->create_time[0]);
				if ($time !== false) {
					$filename[] = $this->create_time[0];
					$criteria->compare('create_time', '>=' . $time);
				}
			}
			if (isset($this->create_time[1])) {
				$time = strtotime($this->create_time[1]);
				if ($time !== false) {
					$filename[] = $this->create_time[1];
					$criteria->compare('create_time', '<=' . $time);
				}
			}
		}
		$codes = $this->findAll($criteria);
		Yii::app()->controller->setIsAjaxRequest();
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename="' . urlencode(implode('-', $filename)) . '.csv"');
		echo implode(",", array(
			'注册码',
			'类型',
			'状态',
			'生成时间',
		));
		echo "\n";
		foreach ($codes as $code) {
			echo implode(",", array(
				$code->code,
				$code->getTypeText(),
				$code->getStatusText(),
				date('Y-m-d H:i:s', $code->create_time),
			)), "\n";
		}
		exit;
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
			// ['code', 'required'],
			['code', 'unique'],
			['status, type, number', 'numerical', 'integerOnly'=>true],
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
			'code' => '注册码',
			'number' => '数量',
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
		$criteria->compare('type', $this->type);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>100,
			),
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			)
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

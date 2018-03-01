<?php

/**
 * This is the model class for table "equipment".
 *
 * The followings are the available columns in table 'equipment':
 * @property string $id
 * @property integer $user_id
 * @property string $category_id
 * @property string $title
 * @property string $title_zh
 * @property string $cover
 * @property string $content
 * @property string $content_zh
 * @property string $sequence
 * @property integer $status
 */
class Equipment extends ActiveRecord {
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

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'equipment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, title, title_zh, content, content_zh', 'required'),
			array('user_id, status, sequence', 'numerical', 'integerOnly'=>true),
			array('category_id, sequence', 'length', 'max'=>10),
			array('title, title_zh', 'length', 'max'=>1024),
			array('cover', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, category_id, title, title_zh, cover, content, content_zh, sequence, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
			'category'=>array(self::BELONGS_TO, 'FaqCategory', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'user_id' => '发布人',
			'category_id' => '分类',
			'title' => '英文名',
			'title_zh' => '中文名',
			'cover' => '封面',
			'content' => '英文介绍',
			'content_zh' => '中文介绍',
			'sequence' => '排序',
			'status' => '状态',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title_zh',$this->title_zh,true);
		$criteria->compare('cover',$this->cover,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_zh',$this->content_zh,true);
		$criteria->compare('sequence',$this->sequence,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'sequence DESC, id DESC',
			),
			'pagination'=>array(
				'pageVar'=>'page',
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Equipment the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}

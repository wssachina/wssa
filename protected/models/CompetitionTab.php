<?php

/**
 * This is the model class for table "competition_tab".
 *
 * The followings are the available columns in table 'competition_tab':
 * @property string $id
 * @property string $competition_id
 * @property string $title
 * @property string $icon
 * @property string $rank
 * @property string $content
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class CompetitionTab extends ActiveRecord {
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'competition_tab';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, icon', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('competition_id, rank, create_time, update_time', 'length', 'max'=>11),
			array('title', 'length', 'max'=>128),
			array('icon', 'length', 'max'=>32),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, competition_id, title, icon, rank, content, status, create_time, update_time', 'safe', 'on'=>'search'),
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
			'competition_id' => 'Competition',
			'title' => 'Title',
			'icon' => 'Icon',
			'rank' => 'Rank',
			'content' => 'Content',
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
		$criteria->compare('competition_id', $this->competition_id, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('icon', $this->icon, true);
		$criteria->compare('rank', $this->rank, true);
		$criteria->compare('content', $this->content, true);
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
	 * @return CompetitionTab the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}

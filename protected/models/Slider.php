<?php

/**
 * This is the model class for table "slider".
 *
 * The followings are the available columns in table 'slider':
 * @property string $id
 * @property string $title
 * @property integer $type
 * @property string $url
 * @property string $image
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Slider extends ActiveRecord {

	public static function getSliders($num) {
		$sliders = self::model()->findAllByAttributes([
			'status'=>self::STATUS_SHOW,
		], [
			'order'=>'create_time DESC',
			'limit'=>$num,
		]);
		$news = News::model()->findAllByAttributes([
			'status'=>News::STATUS_SHOW,
		], [
			'condition'=>'cover!=""',
			'order'=>'weight DESC, date DESC',
			'limit'=>$num,
		]);
		$sliders = array_merge($sliders, array_map(function($news) {
			$slider = [
				'url'=>$news->getUrl(),
				'image'=>$news->cover,
				'title'=>$news->title_zh,
				'create_time'=>$news->date,
			];
			if ($news->weight > 0) {
				$slider['weight'] = $news->weight;
			}
			return $slider;
		}, $news));
		usort($sliders, function($sliderA, $sliderB) {
			if (isset($sliderA['weight']) && $sliderB['weight']) {
				$temp = $sliderB['create_time'] - $sliderA['create_time'];
			} elseif (isset($sliderA['weight'])) {
				return -1;
			} elseif (isset($sliderB['weight'])) {
				return 1;
			} else {
				$temp = $sliderB['create_time'] - $sliderA['create_time'];
			}
			return $temp;
		});
		return array_splice($sliders, 0, $num);
	}

	public function handleDate() {
		if (trim($this->create_time) != '') {
			$createTime = strtotime($this->create_time);
			if ($createTime !== false) {
				$this->create_time = $createTime;
			} else {
				$this->create_time = 0;
			}
		} else {
			$this->create_time = 0;
		}
	}

	public function formatDate() {
		if (!empty($this->create_time)) {
			$this->create_time = date('Y-m-d H:i:s',  $this->create_time);
		} else {
			$this->create_time = '';
		}
	}

	public function getOperationButton() {
		$buttons = array();
		$buttons[] = CHtml::link('编辑',  array('/board/slider/edit',  'id'=>$this->id), array('class'=>'btn btn-xs btn-blue btn-square'));
		if (Yii::app()->user->checkRole(User::ROLE_DELEGATE)) {
			switch ($this->status) {
				case self::STATUS_HIDE:
					$buttons[] = CHtml::link('发布',  array('/board/slider/show',  'id'=>$this->id), array('class'=>'btn btn-xs btn-green btn-square'));
					break;
				case self::STATUS_SHOW:
					$buttons[] = CHtml::link('隐藏',  array('/board/slider/hide',  'id'=>$this->id), array('class'=>'btn btn-xs btn-red btn-square'));
					break;
			}
		}
		return implode(' ',  $buttons);
	}

	protected function beforeValidate() {
		$this->handleDate();
		return parent::beforeValidate();
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'slider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, status', 'numerical', 'integerOnly'=>true),
			array('title, url, image', 'required'),
			array('url', 'url'),
			array('title, url, image', 'length', 'max'=>256),
			array('create_time, update_time', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, type, url, image, status, create_time, update_time', 'safe', 'on'=>'search'),
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
			'title' => '标题',
			'type' => 'Type',
			'url' => '链接',
			'image' => '图片',
			'status' => '状态',
			'create_time' => '时间',
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
		$criteria->compare('title', $this->title, true);
		$criteria->compare('type', $this->type);
		$criteria->compare('url', $this->url, true);
		$criteria->compare('image', $this->image, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>[
				'defaultOrder'=>'create_time DESC',
			],
			'pagination'=>[
				'pageSize'=>50,
			],
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Slider the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}

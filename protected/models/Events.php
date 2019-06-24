<?php

/**
 * This is the model class for table "Events".
 *
 * The followings are the available columns in table 'Events':
 * @property string $id
 * @property string $name
 * @property integer $rank
 */
class Events extends ActiveRecord {
	private static $_allEvents;
	private static $_normalEvents;
	private static $_deprecatedEvents;
	private static $_specialEventNames = array(
		'pyram'=>'pyra',
		'minx'=>'mega',
		'333oh'=>'3oh',
		'333bf'=>'3bld',
		'333mbf'=>'3multi',
		'333ft'=>'3feet',
		'444bf'=>'4bld',
		'555bf'=>'5bld',
	);
	private static $_defaultExportFormats = array(
		'333'=>'average5s',
		'444'=>'average5m',
		'555'=>'average5m',
		'222'=>'average5s',
		'333bf'=>'best3m',
		'333oh'=>'average5s',
		'333fm'=>'mean3n',
		'333ft'=>'mean3m',
		'minx'=>'average5m',
		'pyram'=>'average5s',
		'sq1'=>'average5s',
		'clock'=>'average5s',
		'skewb'=>'average5s',
		'666'=>'mean3m',
		'777'=>'mean3m',
		'444bf'=>'best3m',
		'555bf'=>'best3m',
		'333mbf'=>'multibf1',
		'default'=>'average5s',
	);

	public static $descriptions = [
		'individual'=>'参赛选手被默认为参加所有个人项目，包括3-3-3、3-6-3和Cycle。如果参赛选手无法或不希望参加某一个单项，可以在预赛中主动选择跳过。',
		'age-division'=>'大多数参赛选手与他们接力队伍中的一员组成双人组合。双人项目可男女混合。',
		'child-parent'=>'除了年龄组双人项目比赛以外，参赛选手亦可与“家长”组合参加亲子双人项目比赛。孩子可以与他们的父母、祖父母或法定监护人进行组合，而“父母”则可以与他们直系“子女”进行组合。',
		'relay'=>'每个接力队伍由4至6名选手和1名教练组成。',
	];

	public static $extraDescriptions = [
		'age-division'=>'如果您需要寻求搭档，请在下面输入“<span class="auto-fill">需要搭档</span>”。',
		'child-parent'=>'除了年龄组双人项目比赛以外，参赛选手亦可与“家长”组合参加亲子双人项目比赛。孩子可以与他们的父母、祖父母或法定监护人进行组合，而“父母”则可以与他们直系“子女”进行组合。',
		'relay'=>'如果需要寻找队伍，请在下面输入“<span class="auto-fill">需要组队</span>”。',
	];

	public static function getAllExportFormats() {
		$formats = array(
			'average5s',
			'average5m',
			'mean3s',
			'mean3m',
			'mean3n',
			'best1m',
			'best2m',
			'best3m',
			'best1n',
			'best2n',
			'multibf1',
			'multibf2',
			'best1s',
			'best2s',
			'best3s',
		);
		return array_combine($formats, $formats);
	}

	public static function getDefaultExportFormat($event) {
		return isset(self::$_defaultExportFormats[$event]) ? self::$_defaultExportFormats[$event] : self::$_defaultExportFormats['default'];
	}

	public static function getExportFormat($event, $format) {
		if ($event === '333mbf') {
			return 'multibf' . $format;
		}
		if ($event === '333fm') {
			if ($format == 'm') {
				return 'mean3n';
			} else {
				return 'best' . $format . 'n';
			}
		}
		switch ($format) {
			case '1':
			case '2':
			case '3':
				return 'best' . $format . 's';
			case 'm':
				return 'mean3s';
			default:
				return 'average5s';
		}
	}

	public static function getColumnName($event) {
		if (isset(self::$_specialEventNames[$event])) {
			$event = self::$_specialEventNames[$event];
		}
		return ucfirst($event);
	}

	public static function getEventName($event) {
		$allEvents = self::getAllEvents();
		return isset($allEvents[$event]) ? $allEvents[$event] : $event;
	}

	public static function getEventDescription($event) {
		return isset(self::$descriptions[$event]) ? self::$descriptions[$event] : '';
	}

	public static function getExtraEventDescription($event) {
		return isset(self::$extraDescriptions[$event]) ? self::$extraDescriptions[$event] : '';
	}

	public static function getFullEventName($event) {
		return self::getEventName($event);
	}

	public static function getFullEventNameWithIcon($event, $name = null) {
		if ($name === null) {
			$name = self::getFullEventName($event);
		}
		return self::getEventIcon($event) . ' ' . $name;
	}

	public static function getShortNameWithIcon($event) {
		switch (Yii::app()->language) {
			case 'zh_cn':
				return self::getFullEventNameWithIcon($event, $event === 'submission' ? '交魔方' : null);
			case 'en':
				return self::getFullEventNameWithIcon($event, ucfirst($event));
			case 'zh_tw':
				Yii::app()->language = 'zh_cn';
				$name = self::getFullEventNameWithIcon($event, $event === 'submission' ? '交方块' : null);
				Yii::app()->language = 'zh_tw';
				return Yii::app()->controller->translateTWInNeed($name);
		}
	}

	public static function getEventIcon($event) {
		$name = self::getFullEventName($event);
		$class = ['event-icon', 'event-icon-' . $event];
		if (self::isCustomEvent($event) && !CustomEvent::hasIcon($event)) {
			$class[] = 'event-icon-custom';
		}
		return CHtml::tag('i', [
			'class'=>implode(' ', $class),
			'title'=>$name,
		], '');
	}

	public static function getScheduleEvents() {
		return self::getAllEvents() + self::getOnlyScheduleEvents();
	}

	public static function getRegisterEvents() {
		$events = [];
		$allEvents = self::getAllEvents();
		foreach (['individual', 'age-division', 'child-parent', 'relay'] as $event) {
			$events[$event] = $allEvents[$event];
		}
		return $events;
	}

	public static function getOnlyScheduleEvents() {
		return array(
			'registration'=>'Registration',
			'intro'=>'Opening Intro',
			'lunch'=>'Lunch',
			'break'=>'Break',
			'lucky'=>'Lucky Draw',
			'ceremony'=>'Award Ceremony',
		);
	}

	public static function getAllEvents() {
		if (self::$_allEvents === null) {
			self::$_allEvents = CHtml::listData(self::model()->findAll([
				'order'=>'rank',
			]), 'id', 'name');
		}
		return self::$_allEvents;
	}

	public static function getCustomEvents() {
		return CHtml::listData(CustomEvent::getAllEvents(), 'id', 'name');
	}

	public static function getNormalEvents() {
		if (self::$_normalEvents !== null) {
			return self::$_normalEvents;
		}
		$events = self::model()->cache(86500 * 7)->findAll(array(
			'condition'=>'rank<900',
			'order'=>'parent_id, rank',
		));
		$temp = [];
		foreach ($events as $event) {
			if ($event->isMainEvent()) {
				$temp[$event->id] = [
					'id'=>$event->id,
					'name'=>$event->name,
					'children'=>[],
				];
			} elseif (isset($temp[$event->parent_id])) {
				$temp[$event->parent_id]['children'][$event->id] = [
					'id'=>$event->id,
					'name'=>$event->name,
				];
			}
		}
		return self::$_normalEvents = $temp;
	}

	public static function getParent($event) {

	}

	public static function getNormalTranslatedEvents() {
		$events = self::getNormalEvents();
		foreach ($events as $eventId=>$eventName) {
			$events[$eventId] = Yii::t('event', $eventName);
		}
		return $events;
	}

	public static function getDeprecatedEvents() {
		if (self::$_deprecatedEvents !== null) {
			return self::$_deprecatedEvents;
		}
		$events = self::model()->cache(86500 * 7)->findAll(array(
			'condition'=>'rank>=900 AND rank<1000',
			'order'=>'rank',
		));
		$events = CHtml::listData($events, 'id', 'name');
		return self::$_deprecatedEvents = $events;
	}

	public static function isCustomEvent($event) {
		return array_key_exists($event, self::getCustomEvents());
	}

	public function isMainEvent() {
		return $this->parent_id == '';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rank', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>20),
			array('name', 'length', 'max'=>54),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, rank', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parent'=>[self::BELONGS_TO, 'Events', 'parent_id'],
			'children'=>[self::HAS_MANY, 'Events', 'parent_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('Events', 'ID'),
			'name' => Yii::t('Events', 'Name'),
			'rank' => Yii::t('Events', 'Rank'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('rank',$this->rank);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
}

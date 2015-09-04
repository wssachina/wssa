<?php

class AdminController extends Controller {
	public $layout = '/layouts/main';
	public $alerts = array();
	protected $minIEVersion = '9.0';

	public function beforeAction($action) {
		if (parent::beforeAction($action)) {
			$criteria = new CDbCriteria();
			$criteria->with = array(
				'organizer'=>array(
					'together'=>true,
				),
			);
			$criteria->compare('organizer.organizer_id', Yii::app()->user->id);
			$criteria->compare('t.status', Competition::STATUS_SHOW);
			$competitions = Competition::model()->findAll($criteria);
			foreach ($competitions as $competition) {
				if (!$competition->isScheduleFinished()) {
					$this->alerts[] = array(
						'url'=>array('/board/competition/edit', 'id'=>$competition->id),
						'label'=>sprintf('"%s"赛程不完整', $competition->name_zh),
					);
				}
			}
			Yii::app()->language = 'zh_cn';
			if (strpos($action->id, 'edit') !== false) {
				$this->setReferrer();
			}
			return true;
		}
		return false;
	}

	public function accessRules() {
		return array(
			array(
				'allow',
				'roles'=>array(
					'role'=>User::ROLE_ORGANIZER,
				),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}
}
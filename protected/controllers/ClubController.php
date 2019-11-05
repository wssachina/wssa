<?php

class ClubController extends Controller {
	protected $logAction = false;

	public function accessRules() {
		return array(
			array(
				'allow',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex() {
		$model = new Club();
		$model->unsetAttributes();
		$model->status = Club::STATUS_SHOW;
		$model->province_id = $this->iGet('province');
		if ($model->province_id <= 0) {
			$model->province_id = null;
		}
		$this->title = Yii::t('common', 'Club');
		$this->pageTitle = array($this->title);
		$this->breadcrumbs = array(
			'Club',
		);
		$this->render('index', array(
			'model'=>$model,
		));
	}
}

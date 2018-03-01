<?php

class EquipmentController extends Controller {
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
		$categoryId = $this->iGet('category_id', 1);
		$model = new Equipment();
		$model->unsetAttributes();
		$model->category_id = $categoryId;
		$model->status = Equipment::STATUS_SHOW;
		$categories = EquipmentCategory::getCategoryMenu();
		$this->title = Yii::t('common', 'Equipment');
		$this->pageTitle = array($this->title);
		if ($model->category) {
			$this->pageTitle = array($this->title, $model->category->getAttributeValue('name'));
		}
		$this->breadcrumbs = array(
			'Equipment',
		);
		$this->render('index', array(
			'model'=>$model,
			'categories'=>$categories,
		));
	}

	public function actionDetail() {

	}
}

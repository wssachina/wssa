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

	public function actionItem() {
		$id = $this->iGet('id');
		$model = Equipment::model()->findByAttributes([
			'id'=>$id,
			'status'=>Equipment::STATUS_SHOW,
		]);
		if ($model === null) {
			throw new CHttpException(404, 'Not Found');
		}
		$this->pageTitle = [$model->getAttributeValue('title'), Yii::t('common', 'Equipment')];
		$this->title = $model->getAttributeValue('title');
		$this->breadcrumbs = array(
			'Equipment'=>['/equipment/index'],
			$model->getAttributeValue('title')
		);
		$this->render('item', [
			'equipment'=>$model,
		]);
	}
}

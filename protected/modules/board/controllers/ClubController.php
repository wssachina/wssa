<?php

class ClubController extends AdminController {

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions'=>array('index', 'add', 'edit'),
				'roles'=>array(
					'permission'=>'club',
				),
			),
			array(
				'allow',
				'roles'=>array(
					'permission'=>'club_admin',
				),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdd() {
		$model = new Club();
		$model->status = Club::STATUS_HIDE;
		// $model->unsetAttributes();
		if (isset($_POST['Club'])) {
			$model->attributes = $_POST['Club'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '新加俱乐部成功');
				$this->redirect(array('/board/club/index'));
			}
		}
		$cities = Region::getAllCities();
		$this->render('edit', array(
			'model'=>$model,
			'cities'=>$cities,
		));
	}

	public function actionEdit() {
		$id = $this->iGet('id');
		$model = Club::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if (isset($_POST['Club'])) {
			$model->attributes = $_POST['Club'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '更新俱乐部成功');
				$this->redirect($this->getReferrer());
			}
		}
		$cities = Region::getAllCities();
		$this->render('edit', array(
			'model'=>$model,
			'cities'=>$cities,
		));
	}

	public function actionIndex() {
		$model = new Club();
		$model->unsetAttributes();
		$model->attributes = $this->aRequest('Club');
		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionShow() {
		$id = $this->iGet('id');
		$model = Club::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->status = Club::STATUS_SHOW;
		$model->save();
		Yii::app()->user->setFlash('success', '发布俱乐部成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionHide() {
		$id = $this->iGet('id');
		$model = Club::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->status = Club::STATUS_HIDE;
		$model->save();
		Yii::app()->user->setFlash('success', '隐藏俱乐部成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}
}

<?php

class SliderController extends AdminController {

	public function accessRules() {
		return array(
			array(
				'allow',
				'roles'=>array(
					'role'=>User::ROLE_ADMINISTRATOR,
				),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdd() {
		$model = new Slider();
		$model->create_time = time();
		$model->status = Slider::STATUS_HIDE;
		// $model->unsetAttributes();
		if (isset($_POST['Slider'])) {
			$model->attributes = $_POST['Slider'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '新加Slider成功');
				$this->redirect(array('/board/slider/index'));
			}
		}
		$model->formatDate();
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	public function actionEdit() {
		$id = $this->iGet('id');
		$model = Slider::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if (isset($_POST['Slider'])) {
			$model->attributes = $_POST['Slider'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '更新Slider成功');
				$this->redirect($this->getReferrer());
			}
		}
		$model->formatDate();
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	public function actionIndex() {
		$model = new Slider();
		$model->unsetAttributes();
		$model->attributes = $this->aRequest('Slider');
		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionShow() {
		$id = $this->iGet('id');
		$model = Slider::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->formatDate();
		$model->status = Slider::STATUS_SHOW;
		$model->save();
		Yii::app()->user->setFlash('success', '发布Slider成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionHide() {
		$id = $this->iGet('id');
		$model = Slider::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->formatDate();
		$model->status = Slider::STATUS_HIDE;
		$model->save();
		Yii::app()->user->setFlash('success', '隐藏Slider成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}
}

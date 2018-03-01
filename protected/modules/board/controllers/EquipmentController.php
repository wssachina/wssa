<?php
class EquipmentController extends AdminController {

	public function accessRules() {
		return array(
			array(
				'allow',
				'actions'=>array('index', 'add', 'edit'),
				'roles'=>array(
					'permission'=>'equipment',
				),
			),
			array(
				'allow',
				'roles'=>array(
					'permission'=>'equipment_admin',
				),
			),
			array(
				'deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionAdd() {
		$model = new Equipment();
		$model->user_id = $this->user->id;
		$model->status = Equipment::STATUS_HIDE;
		// $model->unsetAttributes();
		if (isset($_POST['Equipment'])) {
			$model->attributes = $_POST['Equipment'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '新加器材成功');
				$this->redirect(array('/board/equipment/index'));
			}
		}
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	public function actionEdit() {
		$id = $this->iGet('id');
		$model = Equipment::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if (isset($_POST['Equipment'])) {
			$model->attributes = $_POST['Equipment'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '更新器材成功');
				$this->redirect($this->getReferrer());
			}
		}
		$model->format();
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	public function actionIndex() {
		$model = new Equipment();
		$model->unsetAttributes();
		$model->attributes = $this->aRequest('Equipment');
		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionShow() {
		$id = $this->iGet('id');
		$model = Equipment::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->status = Equipment::STATUS_SHOW;
		$model->save();
		Yii::app()->user->setFlash('success', '发布器材成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionHide() {
		$id = $this->iGet('id');
		$model = Equipment::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->status = Equipment::STATUS_HIDE;
		$model->save();
		Yii::app()->user->setFlash('success', '隐藏器材成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionAddCategory() {
		$model = new EquipmentCategory();
		$model->user_id = $this->user->id;
		$model->status = EquipmentCategory::STATUS_HIDE;
		// $model->unsetAttributes();
		if (isset($_POST['EquipmentCategory'])) {
			$model->attributes = $_POST['EquipmentCategory'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '新加器材分类成功');
				$this->redirect(array('/board/equipment/category'));
			}
		}
		$this->render('editCategory', array(
			'model'=>$model,
		));
	}

	public function actionEditCategory() {
		$id = $this->iGet('id');
		$model = EquipmentCategory::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if (isset($_POST['EquipmentCategory'])) {
			$model->attributes = $_POST['EquipmentCategory'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '更新器材分类成功');
				$this->redirect($this->getReferrer());
			}
		}
		$this->render('editCategory', array(
			'model'=>$model,
		));
	}

	public function actionCategory() {
		$model = new EquipmentCategory();
		$model->unsetAttributes();
		$model->attributes = $this->aRequest('EquipmentCategory');
		$this->render('category', array(
			'model'=>$model,
		));
	}

	public function actionShowCategory() {
		$id = $this->iGet('id');
		$model = EquipmentCategory::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->status = EquipmentCategory::STATUS_SHOW;
		$model->save();
		Yii::app()->user->setFlash('success', '发布器材分类成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionHideCategory() {
		$id = $this->iGet('id');
		$model = EquipmentCategory::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		$model->status = EquipmentCategory::STATUS_HIDE;
		$model->save();
		Yii::app()->user->setFlash('success', '隐藏器材分类成功');
		$this->redirect(Yii::app()->request->urlReferrer);
	}
}

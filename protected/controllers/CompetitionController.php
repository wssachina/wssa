<?php

class CompetitionController extends Controller {

	public $competition;

	public function accessRules() {
		return array(
			array(
				'deny',
				'users'=>array('?'),
				'actions'=>array('registration'),
			),
			array(
				'allow',
				'users'=>array('@'),
				'actions'=>array('registration'),
			),
			array(
				'allow',
				'users'=>array('*'),
			),
		);
	}

	public function actionCompetitors() {
		$competition = $this->getCompetition();
		$model = new Registration('search');
		$model->unsetAttributes();
		$model->competition_id = $competition->id;
		$model->status = Registration::STATUS_ACCEPTED;
		$this->render('competitors', array(
			'model'=>$model,
			'competition'=>$competition,
		));
	}

	public function actionDetail() {
		$competition = $this->getCompetition();
		$this->pageTitle = array($competition->getFullName());
		$this->render('detail', array(
			'competition'=>$competition,
		));
	}

	public function actionIndex() {
		$model = new Competition('search');
		$model->unsetAttributes();
		$model->year = $this->sGet('year', 'current');
		$model->type = $this->sGet('type', '');
		$model->province = $this->sGet('province', '');
		$model->event = $this->sGet('event', '');
		$model->status = Competition::STATUS_SHOW;
		$this->title = 'Competition List';
		$this->pageTitle = array('Competition List');
		$this->appendKeywords('Competition List');
		$this->breadcrumbs = array(
			'Competitions',
		);
		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionSignin() {
		$code = $this->sGet('code');
		$registration = Registration::model()->findByAttributes(array(
			'code'=>substr($code, 0, 64),
		));
		if ($registration === null) {
			throw new CHttpException(404, 'Error');
		}
		$this->redirect($registration->competition->getUrl());
	}

	public function actionScan() {
		$competition = $this->getCompetition();
		$session = Yii::app()->session;
		$scanCode = $this->sRequest('scan_code');
		if ($scanCode) {
			$scanAuth = ScanAuth::model()->findByAttributes([
				'competition_id'=>$competition->id,
				'code'=>$scanCode,
			]);
			if ($scanAuth !== null) {
				$session->add('scan_code', $scanAuth->code);
				$this->redirect($scanAuth->competition->getUrl('scan'));
			}
		}
		if ($session->get('scan_code') === null) {
			if ($competition->checkPermission($this->user)) {
				$session->add('scan_code', 'user_' . $this->user->id);
			} else {
				$this->render('scanAuth', [
					'competition'=>$competition,
				]);
				Yii::app()->end();
			}
		}
		$code = $this->sPost('code');
		if ($code != '') {
			$registration = Registration::model()->findByAttributes(array(
				'code'=>substr($code, 0, 64),
			));
			if ($registration == null) {
				$this->ajaxError(404);
			}
			$this->ajaxOK([
				'id'=>$registration->id,
				'number'=>$registration->getUserNumber(),
				'passport'=>$registration->user->passport_number,
				'user'=>[
					'name'=>$registration->user->getCompetitionName(),
				],
				'fee'=>$registration->getTotalFee(),
				'paid'=>!!$registration->paid,
				'signed_in'=>!!$registration->signed_in,
				'signed_date'=>date('Y-m-d H:i:s', $registration->signed_date),
				'has_entourage'=>!!$registration->has_entourage,
				'entourage_name'=>$registration->entourage_name,
				'entourage_passport_type_text'=>$registration->getPassportTypeText(),
				'entourage_passport_number'=>$registration->entourage_passport_number,
				't_shirt_size'=>$registration->getTShirtSizeText(),
				'staff_type'=>$registration->getStaffTypeText(),
			]);
		}
		if (isset($_POST['id'])) {
			$registration = Registration::model()->findByAttributes(array(
				'id'=>$_POST['id'],
			));
			if ($registration === null) {
				$this->ajaxError(404);
			}
			$action = $this->sPost('action');
			switch ($action) {
				case 'pay':
					$registration->paid = Registration::PAID;
					break;
				case 'signin':
					$registration->signed_in = Registration::YES;
					$registration->signed_date = time();
					$registration->signed_scan_code = $session->get('scan_code');
			}
			$registration->formatEvents();
			$registration->save();
			$this->ajaxOK([
				'id'=>$registration->id,
				'number'=>$registration->getUserNumber(),
				'passport'=>$registration->user->passport_number,
				'user'=>[
					'name'=>$registration->user->getCompetitionName(),
				],
				'fee'=>$registration->getTotalFee(),
				'paid'=>!!$registration->paid,
				'signed_in'=>!!$registration->signed_in,
				'signed_date'=>date('Y-m-d H:i:s', $registration->signed_date),
				'has_entourage'=>!!$registration->has_entourage,
				'entourage_name'=>$registration->entourage_name,
				'entourage_passport_type_text'=>$registration->getPassportTypeText(),
				'entourage_passport_number'=>$registration->entourage_passport_number,
				't_shirt_size'=>$registration->getTShirtSizeText(),
				'staff_type'=>$registration->getStaffTypeText(),
			]);
		}

		$application = $this->getWechatApplication([
			'js'=>true,
			'jsConfig'=>[
				'hideAllNonBaseMenuItem',
				'scanQRCode',
			],
		]);
		$min = DEV ? '' : '.min';
		$version = '201704010032';
		$clientScript = Yii::app()->clientScript;
		$clientScript->registerScriptFile('/f/plugins/vue/vue' . $min . '.js');
		$clientScript->registerScriptFile('/f/js/scan.js?ver=' . $version);
		$this->render('scan', [
			'competition'=>$competition,
			'config'=>$config,
		]);
	}

	public function actionRegistration() {
		$competition = $this->getCompetition();
		$user = $this->getUser();
		$registration = Registration::getUserRegistration($competition->id, $user->id);
		if (!$competition->isPublic() || !$competition->isRegistrationStarted() || $competition->tba) {
			Yii::app()->user->setFlash('info', Yii::t('Competition', 'The registration is not open yet.'));
			$this->redirect($competition->getUrl('detail'));
		}
		$showRegistration = $registration !== null && !$registration->isPending();
		if (!$showRegistration) {
			$flashes = [];
			if ($competition->isRegistrationEnded()) {
				$flashes['info'] = Yii::t('Competition', 'The registration has been closed.');
			}
			if ($competition->isRegistrationFull()) {
				if (time() < $competition->cancellation_end_time) {
					$flashes['info'] = Yii::t('Competition', 'The registration has been paused and it will be restarted after {time}.', [
						'{time}'=>date('Y-m-d H:i:s', $competition->reg_reopen_time),
					]);
				} else {
					$flashes['info'] = Yii::t('Competition', 'The registration has been closed.');
				}
			}
			if ($competition->has_been_full && !$competition->isRegistrationFull() &&  time() < $competition->cancellation_end_time) {
				$flashes['info'] = Yii::t('Competition', 'The registration has been paused and it will be restarted after {time}.', [
					'{time}'=>date('Y-m-d H:i:s', $competition->reg_reopen_time),
				]);
			}
			if ($competition->isRegistrationPaused() && !$competition->isRegistrationFull()) {
				$flashes['info'] = Yii::t('Competition', 'The registration has been paused and it will be restarted after {time}.', [
					'{time}'=>date('Y-m-d H:i:s', $competition->reg_reopen_time),
				]);
			}
			if (!empty($flashes)) {
				foreach ($flashes as $type=>$message) {
					Yii::app()->user->setFlash($type, $message);
				}
			}
			if ($competition->person_num > 0) {
				Yii::app()->user->setFlash('warning', Yii::t('Competition', 'Remaining place{s} for registration: {num}.', [
					'{s}'=>$competition->getRemainedNumber() > 1 ? 's' : '',
					'{num}'=>$competition->getRemainedNumber(),
				]));
			}
			if (!empty($flashes)) {
				$this->redirect($competition->getUrl('competitors'));
			}
		}
		if ($user->isUnchecked()) {
			$this->render('registration403', array(
				'competition'=>$competition,
			));
			Yii::app()->end();
		}
		if ($registration !== null) {
			if (isset($_POST['cancel']) && $registration->isCancellable()) {
				if ($registration->cancel()) {
					Yii::app()->user->setFlash('success', Yii::t('Registration', 'Your registration has been cancelled.'));
				}
			}

			if (isset($_POST['Registration']) && $registration->isEditable()) {
				$registration->events = isset($_POST['Registration']['events']) ? $_POST['Registration']['events'] : null;
				$registration->comments = isset($_POST['Registration']['comments']) ? $_POST['Registration']['comments'] : null;
				if ($registration->save()) {
					Yii::app()->user->setFlash('success', '编辑报名信息成功！');
				}
			}
			$registration->formatEvents();
			$this->render('registrationDone', array(
				'user'=>$user,
				'competition'=>$competition,
				'registration'=>$registration,
			));
			Yii::app()->end();
		}
		$unmetEvents = [];
		if ($competition->has_qualifying_time) {
			$unmetEvents = $competition->getUserUnmetEvents($this->user);
		}
		$model = new Registration('register');
		$model->unsetAttributes();
		$model->competition = $competition;
		$model->competition_id = $competition->id;
		$model->events = array_values(PreferredEvent::getUserEvents($user));
		if (isset($_POST['Registration'])) {
			$model->attributes = $_POST['Registration'];
			if (!isset($_POST['Registration']['events'])) {
				$model->events = null;
			}
			$model->user_id = $this->user->id;
			$model->total_fee = $model->getTotalFee(true);
			$model->ip = Yii::app()->request->getUserHostAddress();
			$model->date = time();
			$model->status = Registration::STATUS_PENDING;
			if ($competition->auto_accept == Competition::YES && $competition->online_pay != Competition::ONLINE_PAY) {
				$model->status = Registration::STATUS_ACCEPTED;
			}
			if ($model->save()) {
				Yii::app()->mailer->sendRegistrationNotice($model);
				$this->setWeiboShareDefaultText($competition->getRegistrationDoneWeiboText(), false);
				$model->formatEvents();
				if ($model->isAccepted()) {
					$model->accept();
					$model->formatEvents();
				}
				$this->render('registrationDone', array(
					'user'=>$user,
					'accepted'=>$model->isAccepted(),
					'competition'=>$competition,
					'registration'=>$model,
				));
				Yii::app()->end();
			}
		}
		$model->formatEvents();
		$this->render('registration', array(
			'competition'=>$competition,
			'model'=>$model,
			'unmetEvents'=>$unmetEvents,
		));
	}

	public function actionRegulations() {
		$competition = $this->getCompetition();
		$this->render('regulations', array(
			'competition'=>$competition,
		));
	}

	public function actionSchedule() {
		$competition = $this->getCompetition();
		$userSchedules = [];
		if (!Yii::app()->user->isGuest) {
			$user = $this->getUser();
			$userId = $user->id;
			if ($competition->checkPermission($user)) {
				$userId = $this->iGet('user_id', $userId);
			}
			$registration = Registration::getUserRegistration($competition->id, $userId);
			if ($registration !== null) {
				$userSchedules = $competition->getUserSchedules($registration->user);
			}
		}
		$this->render('schedule', array(
			'competition'=>$competition,
			'userSchedules'=>$userSchedules,
		));
	}

	public function actionTravel() {
		$competition = $this->getCompetition();
		$this->render('travel', array(
			'competition'=>$competition,
			'showMap'=>true,
		));
	}

	protected function getCompetition() {
		$alias = $this->sGet('alias');
		$competition = Competition::getCompetitionByName($alias);
		if ($competition === null || strtolower($alias) != strtolower($competition->getUrlName())) {
			throw new CHttpException(404, 'Error');
		}
		// if (!$competition->isPublic() && !Yii::app()->user->checkRole(User::ROLE_ORGANIZER)) {
		// 	throw new CHttpException(404, 'Error');
		// }
		// $this->setCompetitionNavibar($competition);
		$this->setCompetitionBreadcrumbs($competition);
		$name = $competition->getFullName();
		if ($this->action->id === 'detail') {
			$this->title = $name;
		} else {
			$this->title = $name . '-' . Yii::t('common', ucfirst($this->action->id));
		}
		$this->pageTitle = array($name, ucfirst($this->action->id));
		$this->appendKeywords($name);
		$this->setDescription($competition->getDescription());
		$this->layout = '//layouts/competition';
		$this->competition = $competition;
		return $competition;
	}

	private function setCompetitionBreadcrumbs($competition) {
		if ($this->action->id !== 'detail') {
			$this->breadcrumbs = array(
				'Competitions'=>array('/competition/index'),
				$competition->getFullName()=>$competition->getUrl(),
				ucfirst($this->action->id),
			);
		} else {
			$this->breadcrumbs = array(
				'Competitions'=>array('/competition/index'),
				$competition->getFullName(),
			);
		}
	}

	protected function getCompetitionNavibar($competition) {
		$showLive = $competition->live == Competition::YES && !$competition->canRegister();
		$navibar = array(
			array(
				'label'=>Html::fontAwesome('info-circle', 'a') . Yii::t('Competition', 'Main Page'),
				'url'=>$competition->getUrl('detail'),
				'itemOptions'=>array(
					'class'=>'nav-item',
				),
			),
			// array(
			// 	'label'=>Html::fontAwesome('tasks', 'a') . Yii::t('Competition', 'Regulations'),
			// 	'url'=>$competition->getUrl('regulations'),
			// 	'itemOptions'=>array(
			// 		'class'=>'nav-item',
			// 	),
			// ),
			array(
				'label'=>Html::fontAwesome('calendar', 'a') . Yii::t('Competition', 'Schedule'),
				'url'=>$competition->getUrl('schedule'),
				'itemOptions'=>array(
					'class'=>'nav-item',
				),
			),
			array(
				'label'=>Html::fontAwesome('taxi', 'a') . Yii::t('Competition', 'Travel'),
				'url'=>$competition->getUrl('travel'),
				'itemOptions'=>array(
					'class'=>'nav-item',
				),
			),
			array(
				'label'=>Html::fontAwesome('users', 'a') . Yii::t('Competition', 'Competitors'),
				'url'=>$competition->getUrl('competitors'),
				'itemOptions'=>array(
					'class'=>'nav-item',
				),
			),
			array(
				'label'=>Html::fontAwesome('sign-in', 'a') . Yii::t('Competition', 'Registration'),
				'url'=>$competition->getUrl('registration'),
				'itemOptions'=>array(
					'class'=>'nav-item',
				),
			),
		);
		if ($competition->checkPermission($this->user)) {
			switch ($this->action->id) {
				case 'regulations':
				case 'schedule':
					$action = $this->action->id;
					$url = ['/board/competition/' . $action, 'id'=>$competition->id];
					break;
				case 'competitors':
					$url = ['/board/registration/index', 'Registration'=>['competition_id'=>$competition->id]];
					break;
				case 'tab':
					$url = ['/board/competition/tab', 'id'=>$this->iGet('id')];
					break;
				default:
					$url = ['/board/competition/edit', 'id'=>$competition->id];
					break;
			}
			$navibar[] = [
				'label'=>Html::fontAwesome('edit', 'a') . '编辑',
				'url'=>$url,
				'itemOptions'=>array(
					'class'=>'nav-item cube-white',
				),
				'linkOptions'=>[
					'target'=>'_blank',
				]
			];
		}
		return $navibar;
	}
}

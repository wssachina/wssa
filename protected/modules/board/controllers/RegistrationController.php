<?php

class RegistrationController extends AdminController {

	const ROW_PER_CARD = 11;
	const CARD_PER_PAGE = 3;

	private $pagePerStack = 50;
	private $imageStyle = array(
		array(
			'width'=>72,
			'height'=>71,
			'offsetX'=>2,
			'offsetY'=>-13,
		),
		array(
			'width'=>72,
			'height'=>71,
			'offsetX'=>0,
			'offsetY'=>-14,
		),
	);
	private $scoreCardInfo = array();

	public function actionIndex() {
		$model = new Registration();
		$model->unsetAttributes();
		$model->attributes = $this->aRequest('Registration');
		if ($model->competition_id === null) {
			$model->competition_id = 0;
		}
		if ($this->user->isOrganizer() && $model->competition && !isset($model->competition->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
		}
		$this->render('index', array(
			'model'=>$model,
		));
	}

	public function actionSignin() {
		$model = new Registration();
		$model->unsetAttributes();
		$model->attributes = $this->aRequest('Registration');
		if ($model->competition === null || !$model->competition->show_qrcode) {
			$this->redirect(array('/board/registration/index'));
		}
		if ($this->user->isOrganizer() && $model->competition && !isset($model->competition->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		$scanAuth = ScanAuth::getCompetitionAuth($model->competition) ?: ScanAuth::generateCompetitionAuth($model->competition);
		$this->render('signin', array(
			'model'=>$model,
			'scanAuth'=>$scanAuth,
		));
	}

	public function actionExport() {
		$id = $this->iGet('id');
		$model = Competition::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && !isset($model->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		if (isset($_POST['export'])) {
			$this->export($model, $this->iPost('all'), $this->iPost('xlsx'), $this->iPost('extra'), $this->sPost('order'));
		}
		$exportFormsts = Events::getAllExportFormats();
		$this->render('export', array(
			'model'=>$model,
			'competition'=>$model,
			'exportFormsts'=>$exportFormsts,
		));
	}

	public function actionExportLiveData() {
		$id = $this->iGet('id');
		$model = Competition::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && !isset($model->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		if (Yii::app()->request->getRequestType() === 'POST') {
			$this->exportLiveData($model, $this->iPost('xlsx'));
		}
		$this->render('exportLiveData', array(
			'model'=>$model,
			'competition'=>$model,
		));
	}

	public function actionLiveScoreCard() {
		$id = $this->iGet('id');
		$model = Competition::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && !isset($model->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		if (isset($_POST['event'])) {
			$this->pagePerStack = $this->iPost('stack', 10);
			$this->exportLiveScoreCard($model, $this->sPost('event'), $this->sPost('round'));
		}
		$this->render('scoreCard', array(
			'model'=>$model,
			'competition'=>$model,
		));
	}

	public function actionScoreCard() {
		$id = $this->iGet('id');
		$model = Competition::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && !isset($model->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		if (isset($_POST['order'])) {
			$this->pagePerStack = $this->iPost('stack', 50);
			$this->exportAllScoreCard($model, $this->iPost('all'), $this->sPost('order'), $this->sPost('split'), $this->sPost('direction'));
		}
		$this->render('scoreCard', array(
			'model'=>$model,
			'competition'=>$model,
		));
	}

	public function export($competition, $all = false, $xlsx = false, $extra = false, $order = 'date') {
		$registrations = Registration::getRegistrations($competition, $all, $order);
		$export = new PHPExcel();
		$export->getProperties()
			->setCreator(Yii::app()->params->author)
			->setLastModifiedBy(Yii::app()->params->author)
			->setTitle($competition->wca_competition_id ?: $competition->name)
			->setSubject($competition->name);
		$export->removeSheetByIndex(0);
		//名单
		$sheet = $export->createSheet();
		$sheet->setTitle('参赛名单');
		$col = 'A';
		$columns = [
			'英文名',
			'英文姓',
			'中文姓名',
			'性别',
			'出生年月',
			'国家',
			'省份',
			'学校 / 俱乐部',
			'双人搭档',
			'亲子双人搭档',
			'接力队伍名称',
			'接力队伍教练',
		];
		foreach ($columns as $column) {
			$sheet->setCellValue($col . '1', $column);
			$col++;
		}
		if ($extra) {
			foreach (['手机', '邮箱', '备注'] as $column) {
				$sheet->setCellValue($col . '1', $column);
				$col++;
			}
		}
		$row = 2;
		foreach ($registrations as $key=>$registration) {
			$user = $registration->user;
			$name = explode(' ', $user->name);
			$firstName = implode(' ', array_slice($name, 0, -1));
			$lastName = implode('', array_slice($name, -1));
			$col = 'A';
			$sheet->setCellValue($col . $row, $firstName);
			$col++;
			$sheet->setCellValue($col . $row, $lastName);
			$col++;
			$sheet->setCellValue($col . $row, $user->name_zh);
			$col++;
			$sheet->setCellValue($col . $row, $user->getGenderText());
			$col++;
			$sheet->setCellValue($col . $row, date('Y-m-d', $user->birthday));
			$col++;
			$sheet->setCellValue($col . $row, $user->country->name_zh);
			$col++;
			$sheet->setCellValue($col . $row, $user->province !== null ? $user->province->name_zh : '');
			$col++;
			// 学校 / 俱乐部
			$col++;
			$events = $registration->events;
			if (isset($events['age-division'])) {
				$sheet->setCellValue($col . $row, $events['age-division']['name']);
			}
			$col++;
			if (isset($events['child-parent'])) {
				$sheet->setCellValue($col . $row, $events['child-parent']['name']);
			}
			$col++;
			if (isset($events['relay'])) {
				$sheet->setCellValue($col . $row, $events['relay']['name']);
				$col++;
				$sheet->setCellValue($col . $row, $events['relay']['coordinator']);
			} else {
				$col++;
			}
			$col++;
			//额外信息
			if ($extra) {
				$sheet->setCellValue($col . $row, $user->mobile);
				$col++;
				$sheet->setCellValue($col . $row, $user->email);
				$col++;
				$sheet->setCellValue($col . $row, $registration->comments);
				$col++;
			}
			$row++;
		}
		$this->exportToExcel($export, 'php://output', $competition->name_zh . '名单', $xlsx);
	}

	public function exportLiveData($competition, $xlsx = false) {
		$liveResults = LiveResult::model()->findAllByAttributes(array(
			'competition_id'=>$competition->id,
		), array(
			'condition'=>'best != 0',
		));
		$registrations = array();
		$events = array();
		foreach ($liveResults as $liveResult) {
			$key = $liveResult->user_type . '_' . $liveResult->user->id;
			$round = $liveResult->eventRound;
			if (!isset($registrations[$key])) {
				$registrations[$key] = array(
					'user'=>$liveResult->user,
					'number'=>$liveResult->number,
					'events'=>array(),
				);
			}
			if (!isset($events[$liveResult->event])) {
				$events[$liveResult->event] = array(
					'event'=>$liveResult->wcaEvent,
					'rounds'=>array(),
				);
			}
			if (!isset($events[$liveResult->event]['rounds'][$liveResult->round])) {
				$events[$liveResult->event]['rounds'][$liveResult->round] = array(
					'round'=>$liveResult->wcaRound,
					'format'=>$round->format,
					'results'=>array(),
				);
			}
			$events[$liveResult->event]['rounds'][$liveResult->round]['results'][] = $liveResult;
			$registrations[$key]['events'][$liveResult->event] = $liveResult->event;
		}
		usort($registrations, function($regA, $regB) {
			return $regA['number'] - $regB['number'];
		});
		//sort event
		uasort($events, function($eventA, $eventB) {
			if ($eventA['event'] && $eventB['event']) {
				$temp = $eventA['event']->rank - $eventB['event']->rank;
			} elseif ($eventA && !$eventB) {
				$temp = -1;
			} elseif (!$eventA && $eventB) {
				$temp = 1;
			} else {
				$temp = 0;
			}
			return $temp;
		});
		$template = PHPExcel_IOFactory::load(Yii::getPathOfAlias('application.data.results') . '.xls');
		$export = new PHPExcel();
		$export->getProperties()
			->setCreator(Yii::app()->params->author)
			->setLastModifiedBy(Yii::app()->params->author)
			->setTitle($competition->wca_competition_id ?: $competition->name)
			->setSubject($competition->name);
		$export->removeSheetByIndex(0);
		//注册页
		$sheet = $template->getSheet(0);
		$sheet->setCellValue('A1', $competition->wca_competition_id ?: $competition->name);
		$col = 'J';
		$cubecompsEvents = array(
			'333'=>'3x3',
			'444'=>'4x4',
			'555'=>'5x5',
			'666'=>'6x6',
			'777'=>'7x7',
			'222'=>'2x2',
			'333bf'=>'333bld',
			'333fm'=>'fmc',
			'minx'=>'mega',
			'pyram'=>'pyra',
			'444bf'=>'444bld',
			'555bf'=>'555bld',
			'333mbf'=>'333mlt',
		);
		foreach ($events as $event=>$value) {
			$sheet->setCellValue($col . 2, "=SUM({$col}4:{$col}" . (count($registrations) + 4) . ')');
			$sheet->setCellValue($col . 3, $value['event'] ? (isset($cubecompsEvents[$value['event']->id]) ? $cubecompsEvents[$value['event']->id] : $value['event']->id) : $event);
			$sheet->getColumnDimension($col)->setWidth(5.5);
			$col++;
		}
		foreach ($registrations as $key=>$registration) {
			$user = $registration['user'];
			$row = $key + 4;
			$sheet->setCellValue('A' . $row, $registration['number'])
				->setCellValue('B' . $row, $user->getCompetitionName())
				->setCellValue('C' . $row, $user->country->name)
				->setCellValue('D' . $row, $user->wcaid)
				->setCellValue('E' . $row, $user->getWcaGender())
				->setCellValue('F' . $row, PHPExcel_Shared_Date::FormattedPHPToExcel(
					date('Y', $user->birthday),
					date('m', $user->birthday),
					date('d', $user->birthday)
				));
			$col = 'J';
			foreach ($events as $event=>$value) {
				if (in_array($event, $registration['events'])) {
					$sheet->setCellValue($col . $row, 1);
				}
				$col++;
			}
		}
		$export->addExternalSheet($sheet);
		//各个项目
		$compare = function($resA, $resB) {
			$temp = 0;
			$format = $resA->eventRound->format;
			if ($format == 'm' || $format == 'a') {
				if ($resA->average > 0 && $resB->average <= 0) {
					return -1;
				}
				if ($resB->average > 0 && $resA->average <= 0) {
					return 1;
				}
				$temp = $resA->average - $resB->average;
			}
			if ($temp == 0) {
				if ($resA->best > 0 && $resB->best <= 0) {
					return -1;
				}
				if ($resB->best > 0 && $resA->best <= 0) {
					return 1;
				}
				$temp = $resA->best - $resB->best;
			}
			if ($temp == 0) {
				$temp = $resA->user->name < $resB->user->name ? -1 : 1;
			}
			return $temp;
		};
		foreach ($events as $event=>$value) {
			usort($value['rounds'], function($roundA, $roundB) {
				return $roundA['round']->rank - $roundB['round']->rank;
			});
			foreach ($value['rounds'] as $round) {
				$formatName = Events::getExportFormat($event, $round['format']);
				$sheet = $template->getSheetByName($formatName);
				if ($sheet === null) {
					continue;
				}
				$sheet = clone $sheet;
				$sheet->setTitle("{$event}-{$round['round']->id}");
				$template->addSheet($sheet);
				$sheet->setCellValue('A1', Events::getEventName($event) . ' - ' . RoundTypes::getFullRoundName($round['round']->id));
				usort($round['results'], $compare);
				$row = 5;
				$num = Formats::getFormatNum($round['format']);
				foreach ($round['results'] as $result) {
					//user info
					$user = $result->user;
					$sheet->setCellValue('B' . $row, $user->getCompetitionName())
						->setCellValue('C' . $row, $user->country->name)
						->setCellValue('D' . $row, $user->wcaid)
						->setCellValue('Z' . $row, $result->number);
					//result
					$col = 'E';
					if ($result->event === '333mbf') {
						for ($i = 1; $i <= $result->eventRound->format; $i++) {
							$value = $result->{'value' . $i};
							if ($value == -1 || $value == -2) {
								//tried
								$sheet->setCellValue($col . $row, LiveResult::formatTime($value, $result->event));
								$col++;
								//solved
								$sheet->setCellValue($col . $row, 0);
								$col++;
								//seconds
								$sheet->setCellValue($col . $row, 0);
								$col++;
								$col++;

							} else {
								$difference = 99 - substr($value, 0, 2);
								$missed = intval(substr($value, -2));
								$seconds = intval(substr($value, 3, -2));
								$solved = $difference + $missed;
								$tried = $solved + $missed;
								//tried
								$sheet->setCellValue($col . $row, $tried);
								$col++;
								//solved
								$sheet->setCellValue($col . $row, $solved);
								$col++;
								//seconds
								$sheet->setCellValue($col . $row, $seconds);
								$col++;
								$col++;
							}
						}
					} else {
						for ($i = 1; $i <= $num; $i++) {
							$sheet->setCellValue($col . $row, LiveResult::formatTime($result->{'value' . $i}, $result->event));
							$col++;
						}
					}
					if ($row > 5) {
						$formula = $sheet->getCell('A' . ($row - 1))->getValue();
						$formula = strtr($formula, array(
							'-4'=>'_temp_',
							$row - 1=>$row,
							$row - 2=>$row - 1,
							$row=>$row+1,
						));
						$formula = str_replace('_temp_', '-4', $formula);
						$sheet->setCellValue('A' . $row, $formula);
						//formula for best and average
						while ($col != 'R') {
							$formula = $sheet->getCell($col . ($row - 1))->getValue();
							if (strpos($formula, '=') === 0) {
								$formula = strtr($formula, array(
									$row - 1=>$row,
								));
								$sheet->setCellValue($col . $row, $formula);
							}
							$col++;
						}
					}
					$row++;
				}
				$export->addExternalSheet($sheet);
			}
		}
		$this->exportToExcel($export, 'php://output', $competition->name, $xlsx, true);
	}

	public function exportLiveScoreCard($competition, $event, $round) {
		$liveResults = LiveResult::model()->with('user')->findAllByAttributes([
			'competition_id'=>$competition->id,
			'event'=>$event,
			'round'=>$round,
		], [
			'order'=>'number'
		]);
		$this->exportScoreCard($competition, $liveResults, 'user', 'vertical', $competition->getScheduledRound($event, $round));
	}

	public function exportAllScoreCard($competition, $all = false, $order = 'date', $split = 'user', $direction = 'vertical') {
		$registrations = Registration::getRegistrations($competition, $all, $order);
		$this->exportScoreCard($competition, $registrations, $split, $direction);
	}

	public function exportScoreCard($competition, $registrations, $split = 'user', $direction = 'vertical', $round = null) {
	}

	private function fillScoreCard($pdf, $competition, $scoreCard, $round) {
	}

	public function actionSendNotice() {
		$id = $this->iGet('id');
		$competition = Competition::model()->findByPk($id);
		if ($competition === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && !isset($competition->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		$registration = new Registration();
		$registration->unsetAttributes();
		$registration->competition_id = $id;
		$model = new SendNoticeForm();
		if (isset($_POST['SendNoticeForm'])) {
			$model->attributes = $_POST['SendNoticeForm'];
			if ($model->validate() && $model->send($competition)) {
				Yii::app()->user->setFlash('success', '发送成功！');
				$this->redirect(array('/board/registration/index', 'Registration'=>array('competition_id'=>$id)));
			}
		}
		$this->render('sendNotice', array(
			'model'=>$model,
			'competition'=>$competition,
			'registration'=>$registration,
		));
	}

	public function actionPreviewNotice() {
		$id = $this->iGet('id');
		$competition = Competition::model()->findByPk($id);
		if ($competition === null) {
			throw new CHttpException(404, '未知比赛ID');
		}
		if ($this->user->isOrganizer() && !isset($competition->organizers[$this->user->id])) {
			throw new CHttpException(403, '权限不足');
		}
		$registration = new Registration();
		$registration->unsetAttributes();
		$registration->competition_id = $id;
		$model = new SendNoticeForm();
		if (isset($_POST['SendNoticeForm'])) {
			$model->attributes = $_POST['SendNoticeForm'];
		}
		echo json_encode($model->getPreview($competition));
	}

	public function actionEdit() {
		$id = $this->iGet('id');
		$model = Registration::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && $model->competition && !isset($model->competition->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		$model->setScenario('register');
		if (isset($_POST['Registration'])) {
			$model->attributes = $_POST['Registration'];
			$model->avatar_type = isset($_POST['Registration']['avatar_type']) ? $_POST['Registration']['avatar_type'] : 0;
			if ($model->competition->require_avatar && $model->avatar_type == Registration::AVATAR_TYPE_NOW) {
				$model->avatar_id = $model->user->avatar_id;
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', '更新报名信息成功');
				$this->redirect(array('/board/registration/index', 'Registration'=>array(
					'competition_id'=>$model->competition_id,
				)));
			}
		}
		$model->formatEvents();
		$this->render('edit', array(
			'model'=>$model,
		));
	}

	public function actionCancel() {
		$id = $this->iGet('id');
		$model = Registration::model()->findByPk($id);
		if ($model === null) {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		if ($this->user->isOrganizer() && $model->competition && !isset($model->competition->organizers[$this->user->id])) {
			Yii::app()->user->setFlash('danger', '权限不足！');
			$this->redirect(array('/board/registration/index'));
		}
		if (!$model->isCancellable()) {
			Yii::app()->user->setFlash('danger', '该选手不能退赛');
			$this->redirect(['/board/registration/index', 'Registration'=>['competition_id'=>$model->competition_id]]);
		}
		if (isset($_POST['cancel'])) {
			if ($model->cancel()) {
				Yii::app()->user->setFlash('success', '选手退赛成功');
				$this->redirect(['/board/registration/index', 'Registration'=>['competition_id'=>$model->competition_id]]);
			}
		}
		$model->formatEvents();
		$this->render('cancel', array(
			'model'=>$model,
		));
	}

	public function actionToggle() {
		$id = $this->iRequest('id');
		$attribute = $this->sRequest('attribute');
		$model = Registration::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'Not found');
		}
		$competition = $model->competition;
		if ($competition === null) {
			throw new CHttpException(404, 'Not found');
		}
		if ($this->user->isOrganizer() && !isset($competition->organizers[$this->user->id])) {
			throw new CHttpException(401, 'Unauthorized');
		}
		if ($this->user->role != User::ROLE_ADMINISTRATOR && $attribute == 'status' && !$competition->canRegister()) {
			throw new CHttpException(401, '报名已截止，如需变更请联系代表或管理员');
		}
		if ($model->isCancelled()) {
			throw new CHttpException(401, '已退赛选手不做任何变更');
		}
		$model->$attribute = 1 - $model->$attribute;
		if ($attribute == 'signed_in') {
			if ($model->signed_in) {
				$model->signed_date = time();
				$auth = ScanAuth::getCompetitionAuth($competition);
				$model->signed_scan_code = $auth->code;
			} else {
				$model->signed_date = 0;
			}
		}
		//前面改过status了，所以此处是isAccepted
		if ($attribute == 'status' && $model->isAccepted()) {
			$model->total_fee = $model->getTotalFee(true);
			$model->accept();
		} else {
			$model->save();
		}
		$this->ajaxOk(array(
			'value'=>$model->$attribute,
		));
	}
}

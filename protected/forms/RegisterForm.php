<?php

class RegisterForm extends CFormModel {
	public $step = 1;
	public $invitation_code;
	public $name;
	public $local_name;
	public $gender;
	public $birthday;
	public $province_id = 0;
	public $city_id = 0;
	public $mobile = '';
	public $email;
	public $password;
	public $repeatPassword;
	public $verifyCode;

	const DATE_FORMAT = 'Y-m-d';
	const INVITATION_CODE_KEY = 'registration_invitation_code';

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return [
			['invitation_code', 'required', 'on'=>'step1'],
			['invitation_code', 'checkInvitationCode'],
			['gender, birthday, local_name, email, password, repeatPassword, verifyCode, province_id, city_id, mobile', 'required', 'on'=>'step2'],
			['name', 'safe', 'on'=>'step2'],
			['email', 'email'],
			['email', 'match', 'pattern'=>'{^www\..+@.+$}i', 'not'=>true],
			['email', 'match', 'pattern'=>'{@pp\.com$}i', 'not'=>true],
			['email', 'match', 'pattern'=>'{\.con$}i', 'not'=>true],
			['email', 'match', 'pattern'=>'{qq\.com\.cn$}i', 'not'=>true],
			[
				'invitation_code',
				'exist',
				'className'=>'InvitationCode',
				'attributeName'=>'code',
				'criteria'=>[
					'condition'=>'status=0',
				],
			],
			['birthday', 'checkBirthday', 'on'=>'step2'],
			['name', 'checkName', 'on'=>'step2'],
			['mobile', 'checkMobile', 'on'=>'step2'],
			['gender', 'checkGender', 'on'=>'step2'],
			['email', 'unique', 'className'=>'User', 'attributeName'=>'email'],
			['password', 'length', 'min'=>6],
			['repeatPassword', 'compare', 'compareAttribute'=>'password'],
			['verifyCode', 'captcha', 'on'=>'step2'],
		];
	}

	public function isLastStep() {
		return $this->step === 2;
	}

	public function checkInvitationCode() {
		$session = Yii::app()->session;
		switch ($this->step) {
			case 1:
				$session->add(self::INVITATION_CODE_KEY, $this->invitation_code);
				break;
			case 2:
				$this->invitation_code = $session->get(self::INVITATION_CODE_KEY);
				break;
		}
	}

	public function checkName() {
		$user = User::model()->findByAttributes(array(
			'name_zh'=>$this->local_name,
			'birthday'=>$this->birthday,
			'status'=>User::STATUS_NORMAL,
		), array(
			'condition'=>'role!=' . User::ROLE_UNCHECKED,
		));
		if ($user !== null) {
			$this->addError('local_name', Yii::t('common', 'Please <b>DO NOT</b> repeat registration!'));
		}
	}

	public function checkBirthday() {
		$this->birthday = strtotime($this->birthday);
		if ($this->birthday === false) {
			$this->addError('birthday', Yii::t('common', 'Invalid birthday format'));
			return false;
		}
		if ($this->birthday < strtotime('today -120 years')) {
			$this->addError('birthday', Yii::t('common', 'Please re-check your date of birth and ensure the consistency of ID cards.'));
			return false;
		}
		if ($this->birthday > strtotime('today -1 year')) {
			$this->addError('birthday', Yii::t('common', 'Please re-check your date of birth and ensure the consistency of ID cards.'));
			return false;
		}
	}

	public function checkGender() {
		$genders = User::getGenders();
		if (!array_key_exists($this->gender, $genders)) {
			$this->addError('gender', Yii::t('common', 'Invalid gender.'));
		}
	}

	public function checkMobile() {
		if (!preg_match('{^1[34578]\d{9}$}', $this->mobile)) {
			$this->addError('mobile', Yii::t('common', 'Invalid mobile.'));
		}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'wcaid'=>Yii::t('common', 'WCA ID'),
			'name'=>Yii::t('common', 'Name'),
			'local_name'=>Yii::t('common', 'Name in Local Characters (for Chinese, Japanese, Korean, etc)'),
			'gender'=>Yii::t('common', 'Gender'),
			'birthday'=>Yii::t('common', 'Birthday'),
			'country_id'=>Yii::t('common', 'Region'),
			'province_id'=>Yii::t('common', 'Province'),
			'city_id'=>Yii::t('common', 'City'),
			'mobile'=>Yii::t('common', 'Mobile Number'),
			'email'=>Yii::t('common', 'Email'),
			'password'=>Yii::t('common', 'Password'),
			'repeatPassword'=>Yii::t('common', 'Repeat Password'),
			'verifyCode'=>Yii::t('common', 'Verify Code'),
			'invitation_code'=>'邀请码',
		);
	}

	public function register() {
		$user = new User();
		$user->email = strtolower($this->email);
		$user->password = CPasswordHelper::hashPassword($this->password);
		$user->name = trim(strip_tags($this->name));
		$user->name_zh = trim(strip_tags($this->local_name));
		$user->gender = $this->gender;
		$user->mobile = $this->mobile;
		$user->birthday = $this->birthday;
		$user->country_id = 1;
		$user->province_id = $this->province_id;
		$user->city_id = $this->city_id;
		$user->role = User::ROLE_UNCHECKED;
		$user->reg_time = time();
		$user->reg_ip = Yii::app()->request->getUserHostAddress();
		$user->invitation_code = $this->invitation_code;
		if ($user->save()) {
			$identity = new UserIdentity($this->email,$this->password);
			$identity->id = $user->id;
			Yii::app()->user->login($identity);
			Yii::app()->mailer->sendActivate($user);
			$invitationCode = InvitationCode::model()->findByAttributes([
				'code'=>$this->invitation_code,
			]);
			if ($invitationCode && $invitationCode->isOneTime()) {
				$invitationCode->status = InvitationCode::STATUS_USED;
				$invitationCode->save();
			}
			return true;
		} else {
			return false;
		}
	}
}

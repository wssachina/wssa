<?php


class UserCommand extends CConsoleCommand {
	public function actionList($start = 0, $limit = 10) {
		$users = User::model()->findAll([
			'offset'=>$start,
			'limit'=>$limit,
		]);
		array_walk($users, function($user) {
			echo sprintf("%d: %s\n", $user->id, $user->getCompetitionName());
		});
	}

	public function actionSetAdmin($id) {
		$user = User::model()->findByPk($id);
		if ($user !== null && $this->confirm(sprintf("Set user %s to admin?", $user->name_zh))) {
			$user->role = User::ROLE_ADMINISTRATOR;
			$user->save();
			echo "Success!\n";
		}
	}
}

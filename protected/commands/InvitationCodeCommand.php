<?php

class InvitationCodeCommand extends CConsoleCommand {
	public function actionGenerate($num) {
		for ($i = 0; $i < $num; $i++) {
			$invitationCode = new InvitationCode();
			$invitationCode->save();
		}
	}
}

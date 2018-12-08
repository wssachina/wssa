<?php

class m181208_121835_upgrade_invitation_code extends CDbMigration {
	public function up() {
		$this->addColumn('invitation_code', 'type', 'TINYINT(1) UNSIGNED NOT NULL DEFAULT "0"');
		$this->addColumn('user', 'invitation_code', 'CHAR(10) NOT NULL DEFAULT ""');
	}

	public function down() {
		$this->dropColumn('invitation_code', 'type');
		$this->dropColumn('user', 'invitation_code');
	}
}

<?php

class m181124_150534_add_invitation_code extends CDbMigration {
	public function up() {
		$this->createTable('invitation_code', [
			'id'=>'INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'code'=>'CHAR(10) NOT NULL',
			'status'=>'tinyint(1) UNSIGNED NOT NULL DEFAULT 0',
			'create_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'update_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
		]);
		return true;
	}

	public function down() {
		$this->dropTable('invitation_code');
		return true;
	}
}

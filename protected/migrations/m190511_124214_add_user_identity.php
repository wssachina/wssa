<?php

class m190511_124214_add_user_identity extends CDbMigration {
	public function up() {
		$this->dropColumn('user', 'identity');
		$this->createTable('user_identity', [
			'id'=>'INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'user_id'=>'INT(11) UNSIGNED NOT NULL DEFAULT 0',
			'identity'=>'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
			'status'=>'tinyint(1) UNSIGNED NOT NULL DEFAULT 0',
			'create_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'update_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
		]);
		return true;
	}

	public function down() {
		$this->addColumn('user', 'identity', 'INT(11) UNSIGNED NOT NULL DEFAULT 0');
		$this->dropTable('user_identity');
		return true;
	}
}

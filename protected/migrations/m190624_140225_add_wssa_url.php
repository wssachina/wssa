<?php

class m190624_140225_add_wssa_url extends CDbMigration {
	public function up() {
		$this->addColumn('competition', 'wssa_url', 'varchar(256) DEFAULT ""');
		return true;
	}

	public function down() {
		$this->dropColumn('competition', 'wssa_url');
		return true;
	}
}

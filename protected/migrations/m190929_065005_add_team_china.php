<?php

class m190929_065005_add_team_china extends CDbMigration {
	public function up() {
		$this->addColumn('competition', 'team_china_preserved_date', 'INT(11) UNSIGNED NOT NULL DEFAULT 0');
		return true;
	}

	public function down() {
		$this->dropColumn('competition', 'team_china_preserved_date');
		return true;
	}
}

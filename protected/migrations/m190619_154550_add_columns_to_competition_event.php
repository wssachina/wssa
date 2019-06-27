<?php

class m190619_154550_add_columns_to_competition_event extends CDbMigration {
	public function up() {
		$this->addColumn('competition_event', 'podiums', 'INT(11) UNSIGNED NOT NULL DEFAULT 0');
		return true;
	}

	public function down() {
		$this->dropColumn('competition_event', 'podiums');
		return true;
	}
}

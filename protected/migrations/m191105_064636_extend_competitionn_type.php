<?php

class m191105_064636_extend_competitionn_type extends CDbMigration {
	public function up() {
		$this->alterColumn('competition', 'type', 'CHAR(20) DEFAULT ""');
		return true;
	}

	public function down() {
		return true;
	}
}

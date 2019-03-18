<?php

class m190318_145751_add_cover_to_news extends CDbMigration {
	public function up() {
		$this->addColumn('news', 'cover', 'varchar(256) DEFAULT ""');
		return true;
	}

	public function down() {
		$this->dropColumn('news', 'cover');
		return true;
	}
}

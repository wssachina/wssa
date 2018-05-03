<?php

class m180503_150749_create_club_table extends CDbMigration {
	public function up() {
		$this->createTable('club', [
			'id'=>'int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'name'=>'varchar(256) DEFAULT ""',
			'province_id'=>'int(11) UNSIGNED NOT NULL',
			'city_id'=>'int(11) UNSIGNED NOT NULL',
			'address'=>'varchar(256) DEFAULT ""',
			'contact_name'=>'varchar(256) DEFAULT ""',
			'phone'=>'varchar(256) DEFAULT ""',
			'status'=>'tinyint(1) UNSIGNED NOT NULL DEFAULT 0',
			'create_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'update_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
		]);
		$this->createIndex('province_city', 'club', ['province_id', 'city_id']);
		return true;
	}

	public function down() {
		$this->dropTable('club');
		return true;
	}
}

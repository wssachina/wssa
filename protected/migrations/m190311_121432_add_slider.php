<?php

class m190311_121432_add_slider extends CDbMigration {
	public function up() {
		$this->createTable('slider', [
			'id'=>'int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT',
			'title'=>'varchar(256) DEFAULT ""',
			'type'=>'tinyint(1) UNSIGNED NOT NULL DEFAULT 0',
			'url'=>'varchar(256) DEFAULT ""',
			'image'=>'varchar(256) DEFAULT ""',
			'status'=>'tinyint(1) UNSIGNED NOT NULL DEFAULT 0',
			'create_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
			'update_time'=>'int(11) UNSIGNED NOT NULL DEFAULT 0',
		]);
		$this->createIndex('create_time', 'slider', ['status', 'create_time']);
		return true;
	}

	public function down() {
		$this->dropTable('slider');
		return true;
	}
}

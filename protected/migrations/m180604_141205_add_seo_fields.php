<?php

class m180604_141205_add_seo_fields extends CDbMigration {
	public $tables = ['news', 'config'];
	public $fields = [
		'meta_title'=>'VARCHAR(256) DEFAULT ""',
		'meta_description'=>'VARCHAR(1024) DEFAULT ""',
		'meta_keywords'=>'VARCHAR(256) DEFAULT ""',
	];

	public function up() {
		foreach ($this->tables as $table) {
			foreach ($this->fields as $field=>$define) {
				$this->addColumn($table, $field, $define);
			}
		}
		return true;
	}

	public function down() {
		foreach ($this->tables as $table) {
			foreach ($this->fields as $field=>$define) {
				$this->dropColumn($table, $field);
			}
		}
		return true;
	}
}

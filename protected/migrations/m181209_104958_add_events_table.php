<?php

class m181209_104958_add_events_table extends CDbMigration {
	public function up() {
		$this->createTable('events', [
			'id'=>'varchar(20) NOT NULL PRIMARY KEY',
			'name'=>"varchar(54) NOT NULL DEFAULT ''",
			'rank'=>"int(11) NOT NULL DEFAULT '0'",
			'parent_id'=>"varchar(20) NOT NULL DEFAULT ''",
		]);
		$events = [
			[
				'id'=>'individual',
				'name'=>'个人项目',
				'rank'=>1,
				'children'=>[
					[
						'id'=>'333',
						'name'=>'3-3-3',
						'rank'=>1,
					],
					[
						'id'=>'363',
						'name'=>'3-6-3',
						'rank'=>2,
					],
					[
						'id'=>'cycle',
						'name'=>'Cycle',
						'rank'=>3,
					],
				],
			],
			[
				'id'=>'doubles',
				'name'=>'双人项目',
				'rank'=>2,
				'children'=>[
					[
						'id'=>'age-division',
						'name'=>'年龄组双人',
						'rank'=>1,
					],
					[
						'id'=>'child-parent',
						'name'=>'亲子双人',
						'rank'=>2,
					],
				],
			],
			[
				'id'=>'relay',
				'name'=>'接力项目',
				'rank'=>3,
				'children'=>[
					[
						'id'=>'timed-363',
						'name'=>'3-6-3计时接力',
						'rank'=>1,
					],
					[
						'id'=>'hth-363',
						'name'=>'3-6-3对抗接力',
						'rank'=>2,
					],
					[
						'id'=>'hth-cycle',
						'name'=>'Cycle对抗接力',
						'rank'=>3,
					],
				],
			],
		];
		foreach ($events as $event) {
			$model = new Events();
			$model->attributes = $event;
			$model->save();
			foreach ($event['children'] as $e) {
				$model = new Events();
				$model->attributes = $e;
				$model->parent_id = $event['id'];
				$model->save();
			}
		}
		return true;
	}

	public function down() {
		$this->dropTable('events');
		return true;
	}
}

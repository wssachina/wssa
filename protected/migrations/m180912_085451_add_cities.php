<?php

class m180912_085451_add_cities extends CDbMigration {
	public $cities = [
		'江苏'=>[
			'常熟'=>'Changshu',
			'昆山'=>'Kunshan',
			'宜兴'=>'Yixing',
		],
		'山东'=>[
			'莱阳'=>'Laiyang',
		],
		'浙江'=>[
			'义乌'=>'Yiwu',
		],
	];

	public function up() {
		foreach ($this->cities as $provinceName=>$cities) {
			$province = Region::model()->findByAttributes([
				'name_zh'=>$provinceName,
			]);
			if ($province === null) {
				continue;
			}
			foreach ($cities as $cityName=>$englishName) {
				$city = Region::model()->findByAttributes([
					'name_zh'=>$cityName,
					'pid'=>$province->id
				]);
				if ($city !== null) {
					continue;
				}
				$city = new Region();
				$city->name_zh = $cityName;
				$city->name = $englishName;
				$city->pid = $province->id;
				if ($city->save()) {
					echo $cityName . " added\n";
				} else {
					echo $cityName . " failed\n";
				}
			}
		}
		return true;
	}

	public function down() {
		return true;
	}
}

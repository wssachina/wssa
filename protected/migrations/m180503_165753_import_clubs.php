<?php

class m180503_165753_import_clubs extends CDbMigration {
	public function up() {
		$file = fopen(BASE_PATH . '/data/clubs.csv', 'r');

		while ($info = fgetcsv($file)) {
			list($name, $city, $address, $contactName, $phone) = $info;
			$club = Club::model()->findByAttributes(['name'=>$name]);
			if ($club !== null) {
				echo $name, ": existed\n";
				continue;
			}
			$city = Region::model()->findByAttributes([
				'name_zh'=>$city,
			]);
			if ($city === null) {
				echo $name, ": matching city failed\n";
				continue;
			}
			if (in_array($city->id, [215, 525, 567, 642])) {
				$province = $city;
				$city = Region::model()->findByAttributes(['pid'=>$province->id]);
			} else {
				$province = $city->parent;
			}
			$club = new Club();
			$club->province_id = $province->id;
			$club->city_id = $city->id;
			$club->name = $name;
			$club->address = $address;
			$club->contact_name = $contactName;
			$club->phone = $phone;
			$club->status = Club::STATUS_SHOW;
			if ($club->save()) {
				echo $name, ": success\n";
			} else {
				echo $name, ": saving failed\n";
			}
		}
	}

	public function down() {
		return true;
	}
}

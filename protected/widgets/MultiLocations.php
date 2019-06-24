<?php

class MultiLocations extends Widget {
	public $model;
	public $delegates = [];
	public $cities = array();
	public function run() {
		$model = $this->model;
		$cities = $this->cities;
		$locations = $model->locations;
		if (empty($locations)) {
			$location = new CompetitionLocation();
			$locations = array(
				$location->attributes,
			);
		}
		//tab content
		echo CHtml::openTag('div', array(
			'class'=>'row locations',
		));
		foreach ($locations as $key=>$location) {
			$index = $key + 1;
			echo CHtml::openTag('div', array(
				'class'=>'location' . ($key == 0 ? ' active' : ''),
				'id'=>'location-' . $index,
			));
			echo Html::formGroup(
				$model, 'locations[province_id][]', array(
					'class'=>'col-lg-6',
				),
				CHtml::label('省份', false),
				CHtml::dropDownList(CHtml::activeName($model, 'locations[province_id][]'), $location['province_id'], Region::getProvinces(false), array(
					'class'=>'form-control province',
					'prompt'=>'',
				)),
				CHtml::error($model, 'locations.province_id.' . $key, array('class'=>'text-danger'))
			);
			echo Html::formGroup(
				$model, 'locations[city_id][]', array(
					'class'=>'col-lg-6',
				),
				CHtml::label('城市', false),
				CHtml::dropDownList(CHtml::activeName($model, 'locations[city_id][]'), $location['city_id'], isset($cities[$location['province_id']]) ? $cities[$location['province_id']] : array(), array(
					'class'=>'form-control city',
					'prompt'=>'',
				)),
				CHtml::error($model, 'locations.city_id.' . $key, array('class'=>'text-danger'))
			);
			echo Html::formGroup(
				$model, 'locations[venue_zh][]', array(
					'class'=>'col-lg-12',
				),
				CHtml::label('详细地址', false),
				CHtml::textField(CHtml::activeName($model, 'locations[venue_zh][]'), $location['venue_zh'], array(
					'class'=>'form-control',
				)),
				CHtml::error($model, 'locations.venue_zh.' . $key, array('class'=>'text-danger help-block')),
				'<div class="text-danger">请填写具体地址，略去省市</div>'
			);
			echo '<div class="col-lg-12">填写经纬度将会自动生成地图。<br>
			<a href="http://www.gpsspg.com/maps.htm" target="_blank">点击这里查询坐标</a>，国内请填写<b class="text-danger">Google地球</b>坐标。<br>
			请注意经纬度不要填反！
			</div>';
			echo Html::formGroup(
				$model, 'locations[longitude][]', array(
					'class'=>'col-lg-6',
				),
				CHtml::label('经度', false),
				CHtml::textField(CHtml::activeName($model, 'locations[longitude][]'), $location['longitude'], array(
					'class'=>'form-control',
				)),
				CHtml::error($model, 'locations.longitude.' . $key, array('class'=>'text-danger'))
			);
			echo Html::formGroup(
				$model, 'locations[latitude][]', array(
					'class'=>'col-lg-6',
				),
				CHtml::label('纬度', false),
				CHtml::textField(CHtml::activeName($model, 'locations[latitude][]'), $location['latitude'], array(
					'class'=>'form-control',
				)),
				CHtml::error($model, 'locations.latitude.' . $key, array('class'=>'text-danger'))
			);
			echo CHtml::closeTag('div');
		}
		echo CHtml::closeTag('div');
		Yii::app()->clientScript->registerScript('MultiLocations',
<<<EOT
  $(document).on('click', '#addLocation', function() {
    var location = $('.location:last').clone();
    var index = $('.location').length + 1;
    var tab = $('<a role="tab" data-toggle="tab">').attr('href', '#location-' + index).text('地址' + index);
    location.appendTo($('.locations'));
    location.find('.province').val('').trigger('change');
    location.find('input').val('');
    location.attr('id', 'location-' + index).removeClass('active');
    $('<li>').append(
      tab
    ).insertBefore($('#addLocation').parent());
    tab.tab('show');
  });
EOT
		);
	}
}

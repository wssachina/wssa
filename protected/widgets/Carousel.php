<?php

class Carousel extends Widget {
	public $items = [];
	public $options = [];
	public $htmlOptions = [];
	public $itemOptions = [
		'class'=>'slider-item',
	];

	public function run() {
		echo CHtml::openTag('div', $this->htmlOptions);

		foreach ($this->items as $item) {
			$itemOptions = array_merge($this->itemOptions, isset($item['options']) ? $item['options'] : []);
			echo CHtml::openTag('div', $itemOptions);
			echo CHtml::link(
				CHtml::image($item['image']) .
				CHtml::tag('div', ['class'=>'slider-title'], $item['title']),
				$item['url'], ['target'=>'_blank']);
			echo CHtml::closeTag('div');
		}

		echo CHtml::closeTag('div');
	}
}

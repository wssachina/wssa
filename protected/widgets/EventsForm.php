<?php

class EventsForm extends Widget {
	public $model;
	public $competition;
	public $name = 'events';
	public $events = [];
	public $unmetEvents = [];
	public $shouldDisableUnmetEvents = false;
	public $type = 'checkbox';
	public $htmlOptions = [];
	public $labelOptions = [];
	public $numberOptions = [];
	public $feeOptions = [];
	public function run() {
		$events = $this->events;
		$model = $this->model;
		$competition = $this->competition;
		$htmlOptions = $this->htmlOptions;
		echo CHtml::openTag('div', $htmlOptions);
		foreach ($events as $event) {
			echo '<div class="main-event">';
			$this->renderEvent($event);
			if ($event['children'] == []) {
				continue;
			}
			echo '<div class="child-events hide">';
			foreach ($event['children'] as $e) {
				$this->renderEvent($e, true);
			}
			echo '</div>';
			echo '</div>';
		}
		echo CHtml::error($model, 'events', ['class'=>'text-danger']);
		echo CHtml::closeTag('div');
	}

	private function renderEvent($event, $isChild = false) {
		$model = $this->model;
		$name = $this->name;
		echo CHtml::openTag('div', [
			'class'=>'checkbox',
		]);
		echo CHtml::openTag('label');
		$options = [
			'id'=>'Registration_events_' . $event['id'],
			'class'=>'registration-events',
			'value'=>$event['id'],
		];
		echo CHtml::checkBox(CHtml::activeName($model, $name . '[]'), $model->containsEvent($event['id']), $options);
		echo Events::getFullEventNameWithIcon($event['id']);
		echo CHtml::closeTag('label');
		echo CHtml::closeTag('div');
	}
}

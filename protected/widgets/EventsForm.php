<?php

class EventsForm extends Widget {
	public $model;
	public $competition;
	public $name = 'events';
	public $events = [];
	public $htmlOptions = [];
	public $isAdmin = false;
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
		echo CHtml::checkBox(CHtml::activeName($model, "{$name}[{$event['id']}][id]"), $model->containsEvent($event['id']), $options);
		echo Events::getFullEventName($event['id']);
		echo CHtml::closeTag('label');
		if ($this->isAdmin && $isChild) {
			echo CHtml::label('&nbsp;&nbsp;&nbsp;&nbsp;<b>领奖台</b>&nbsp;&nbsp;&nbsp;&nbsp;', '');
			echo CHtml::numberField(CHtml::activeName($model, "{$name}[{$event['id']}][podiums]"), $model->getEventPodiums($event['id']));
		}
		echo CHtml::closeTag('div');
	}
}

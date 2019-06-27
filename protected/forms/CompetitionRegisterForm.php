<?php

class CompetitionRegisterForm extends Widget {
	public $model;
	public $competition;
	public $name = 'events';
	public $form;
	public function run() {
		$events = Events::getRegisterEvents();
		$model = $this->model;
		$competition = $this->competition;
		echo CHtml::tag('div', ['class'=>'registration-events-description'], '请选择你想参与的项目。对于双人项目和接力项目，请确保在比赛前与您的合作伙伴/团队成员协调。');
		echo CHtml::openTag('div', [
			'class'=>'register-events',
		]);
		foreach ($events as $event=>$name) {
			if (!$competition->containsEvent($event)) {
				continue;
			}
			echo '<div class="register-event">';
			echo '<div class="event-info">';
			echo '<label>';
			$options = [
				'id'=>'Registration_events_' . $event,
				'class'=>'registration-events',
				'value'=>$event,
			];
			if ($event === 'individual') {
				$options['checked'] = $model->containsEvent($event) || $event === 'individual';
				$options['disabled'] = true;
			}
			$description = Events::getEventDescription($event);
			$attribute = "{$this->name}[$event]";
			echo CHtml::tag('span', ['class'=>'checkbox-wrapper'], CHtml::activeCheckBox($model, $attribute . '[checked]', $options));
			echo CHtml::tag('span', ['class'=>'event-name'], $name);
			echo '</label>';
			if ($description) {
				echo CHtml::tag('span', [
					'class'=>'has-tooltip',
					'data-toggle'=>'tooltip',
					'title'=>$description,
				], Html::fontAwesome('question-circle'));
			}
			echo '</div>';
			switch ($event) {
				case 'age-division':
				case 'child-parent':
					$extraDescription = Events::getExtraEventDescription($event);
					echo '<div class="extra-info">';
					echo CHtml::tag('div', ['class'=>'extra-description'], $extraDescription);
					echo '<label class="extra-input-wrapper">';
					$label = '搭档姓名';
					if ($event === 'child-parent') {
						$label = '亲子' . $label;
					}
					echo CHtml::tag('div', ['class'=>'extra-input-label'], $label);
					echo CHtml::activeTextField($model, $attribute . '[name]');
					echo '</label>';
					echo $this->form->error($model, "events.{$event}.name", array('class'=>'text-danger'));
					echo '</div>';
					break;
				case 'relay':
					$extraDescription = Events::getExtraEventDescription($event);
					echo '<div class="extra-info">';
					echo CHtml::tag('div', ['class'=>'extra-description'], $extraDescription);
					echo '<label class="extra-input-wrapper">';
					echo CHtml::tag('div', ['class'=>'extra-input-label'], '队伍名称');
					echo CHtml::activeTextField($model, $attribute . '[name]');
					echo '</label>';
					echo $this->form->error($model, "events.{$event}.name", array('class'=>'text-danger'));
					echo '<label class="extra-input-wrapper">';
					echo CHtml::tag('div', ['class'=>'extra-input-label'], '教练姓名');
					echo CHtml::activeTextField($model, $attribute . '[coordinator]');
					echo '</label>';
					echo $this->form->error($model, "events.{$event}.coordinator", array('class'=>'text-danger'));
					echo '</div>';
					break;
			}
			echo '</div>';
		}
		echo CHtml::error($model, 'events', ['class'=>'text-danger']);
		echo CHtml::closeTag('div');
	}
}

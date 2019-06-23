<?php $form = $this->beginWidget('ActiveForm', array(
  'id'=>'registration-form',
  'htmlOptions'=>array(
  ),
)); ?>
  <?php if (!$competition->multi_countries): ?>
  <p><b><?php echo Yii::t('Competition', 'Entry Fee'); ?></b></p>
  <p><i class="fa fa-rmb"></i><?php echo $competition->getEventFee('entry'); ?></p>
  <?php endif; ?>
  <?php echo Html::formGroup(
    $model, 'events', array(),
    $form->labelEx($model, 'events'),
    $this->widget('EventsForm', array(
      'model'=>$model,
      'competition'=>$competition,
      'name'=>'events',
      'events'=>$competition->getRegistrationEvents(),
    ), true)
    // $form->error($model, 'events', array('class'=>'text-danger'))
  );?>
  <hr>
  <?php if ($competition->fill_passport && $this->user->passport_type == User::NO): ?>
  <div class="bg-danger important-border">
    <b class="text-danger">
      <?php echo Yii::t('Registration', 'Please fill your ID number {here} before you register.', [
        '{here}'=>CHtml::link(Yii::t('common', 'here'), ['/user/edit']),
      ]); ?>
    </b>
  </div>
  <?php endif; ?>
  <?php echo Html::formGroup(
    $model, 'comments', array(),
    $form->labelEx($model, 'comments'),
    $form->textArea($model, 'comments', array(
      'class'=>'form-control',
      'rows'=>4,
    )),
    $form->error($model, 'comments', array('class'=>'text-danger'))
  ); ?>
  <div class="checkbox">
    <label>
      <input id="disclaimer" value="agree" type="checkbox" name="disclaimer" checked>
      <?php echo Yii::t('Competition', 'I have read and know the {disclaimer} of Cubing China.', [
        '{disclaimer}'=>CHtml::link(Yii::t('Competition', 'disclaimer'), ['/site/page', 'view'=>'disclaimer']),
      ]); ?>
    </label>
  </div>
  <?php echo CHtml::tag('button', [
    'type'=>'submit',
    'class'=>'btn btn-theme',
    'id'=>'submit-button',
    'disabled'=>$competition->fill_passport && $this->user->passport_type == User::NO,
  ], Yii::t('common', 'Submit')); ?>
<?php $this->endWidget(); ?>
<div class="modal fade" tabindex="-1" role="dialog" id="tips-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo Yii::t('common', 'Tips'); ?></h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="cancel-button"><?php echo Yii::t('common', 'Close'); ?></button>
        <button type="button" class="btn btn-theme" id="confirm-button"><?php echo Yii::t('common', 'Confirm'); ?></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<?php
$options = json_encode([
  'multiCountries'=>!!$competition->multi_countries,
  'showRegulations'=>!!$competition->show_regulations,
  'regulationDesc'=>Yii::t('Competition', 'Please deeply remember the followings to avoid any inconveniences.'),
  'basicFee' => $competition->getEventFee('entry'),
  'regulations'=>[],
  'unmetEvents'=>$unmetEvents,
  'qualifyingEnd'=>date('Y-m-d H:i:s', $competition->qualifying_end_time),
  'unmetEventsMessage'=>Yii::t('Competition', 'You must meet the qualifying times of following events before <b>{date}</b> or they will be removed.', [
    '{date}'=>date('Y-m-d H:i:s', $competition->qualifying_end_time),
  ]),
  'delimiter'=>Yii::t('common', ', '),
]);
echo <<<EOT
<script>
  window.registrationOptions = {$options};
</script>
EOT
;
Yii::app()->clientScript->registerScriptFile('/f/js/registration' . (DEV ? '' : '.min') . '.js?ver=20170827');

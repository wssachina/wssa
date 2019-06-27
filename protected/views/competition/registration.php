<?php $form = $this->beginWidget('ActiveForm', array(
  'id'=>'registration-form',
  'htmlOptions'=>array(
  ),
)); ?>
  <p><b><?php echo Yii::t('Competition', 'Entry Fee'); ?></b></p>
  <p><i class="fa fa-rmb"></i><?php echo $competition->getEventFee('entry'); ?></p>
  <?php $this->renderPartial('registrationForm', [
    'model'=>$model,
    'competition'=>$competition,
    'form'=>$form,
  ]); ?>
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

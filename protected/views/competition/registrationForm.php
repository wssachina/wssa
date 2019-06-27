<?php echo Html::formGroup(
  $model, 'events', array(),
  $form->labelEx($model, 'events'),
  $this->widget('CompetitionRegisterForm', array(
    'model'=>$model,
    'competition'=>$competition,
    'form'=>$form,
  ), true)
  // $form->error($model, 'events', array('class'=>'text-danger'))
);?>
<hr>
<?php echo Html::formGroup(
  $model, 'comments', array(),
  $form->labelEx($model, 'comments'),
  $form->textArea($model, 'comments', array(
    'class'=>'form-control',
    'rows'=>4,
  )),
  $form->error($model, 'comments', array('class'=>'text-danger'))
); ?>

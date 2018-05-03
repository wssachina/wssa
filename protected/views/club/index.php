<div class="col-lg-12">
  <?php $form = $this->beginWidget('ActiveForm', array(
    'htmlOptions'=>array(
      'role'=>'form',
      'class'=>'form-inline',
    ),
    'method'=>'get',
    'action'=>array('/club/index'),
  )); ?>
  <?php echo Html::formGroup(
    $model, 'province', array(),
    $form->labelEx($model, 'province'),
    CHtml::dropDownList('province', $model->province, Region::getProvinces(false), array(
      'class'=>'form-control',
      'prompt'=>Yii::t('common', 'All'),
    ))
  );?>
  <button type="submit" class="btn btn-theme"><?php echo Yii::t('common', 'Submit'); ?></button>
  <?php $this->endWidget(); ?>
  <?php $this->widget('GridView', array(
    'dataProvider'=>$model->search(),
    // 'filter'=>false,
    'template'=>'{items}{pager}',
    'enableSorting'=>true,
    'front'=>true,
    'emptyText'=>'暂无俱乐部',
    'columns'=>array(
      'name',
      array(
        'name'=>'city_id',
        'type'=>'raw',
        'value'=>'$data->getCityInfo()',
      ),
      'address',
      'contact_name',
      'phone',
    ),
  )); ?>
</div>

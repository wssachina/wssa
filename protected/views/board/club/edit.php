<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1><?php echo $model->isNewRecord ? '新增' : '编辑'; ?>俱乐部</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
        <div class="portlet-title">
          <h4>俱乐部信息</h4>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-collapse collapse in">
        <div class="portlet-body">
          <?php $form = $this->beginWidget('ActiveForm', array(
            'htmlOptions'=>array(
              'class'=>'clearfix row',
            ),
            'enableClientValidation'=>true,
          )); ?>
          <?php echo Html::formGroup(
            $model, 'name', array(
              'class'=>'col-lg-12',
            ),
            $form->labelEx($model, 'name', array(
            )),
            Html::activeTextField($model, 'name'),
            $form->error($model, 'name', array('class'=>'text-danger'))
          );?>
          <div class="clearfix"></div>
          <?php echo Html::formGroup(
            $model, 'province_id', [
              'class'=>'col-lg-3 col-md-6',
            ],
            $form->labelEx($model, 'province_id', [
              'label'=>'省份',
            ]),
            $form->dropDownList($model, 'province_id', Region::getProvinces(), [
              'class'=>'form-control',
              'prompt'=>'',
            ]),
            $form->error($model, 'province_id', ['class'=>'text-danger'])
          );?>
          <?php echo Html::formGroup(
            $model, 'city_id', [
              'class'=>'col-lg-3 col-md-6',
            ],
            $form->labelEx($model, 'city_id', [
              'label'=>'城市',
            ]),
            $form->dropDownList($model, 'city_id', isset($cities[$model->province_id]) ? $cities[$model->province_id] : [], [
              'prompt'=>'',
              'class'=>'form-control',
            ]),
            $form->error($model, 'city_id', ['class'=>'text-danger'])
          );?>
          <div class="clearfix hidden-lg"></div>
          <?php echo Html::formGroup(
            $model, 'contact_name', array(
              'class'=>'col-lg-6',
            ),
            $form->labelEx($model, 'contact_name', array(
            )),
            Html::activeTextField($model, 'contact_name'),
            $form->error($model, 'contact_name', array('class'=>'text-danger'))
          );?>
          <?php echo Html::formGroup(
            $model, 'phone', array(
              'class'=>'col-lg-6',
            ),
            $form->labelEx($model, 'phone', array(
            )),
            Html::activeTextField($model, 'phone'),
            $form->error($model, 'phone', array('class'=>'text-danger'))
          );?>
          <?php echo Html::formGroup(
            $model, 'address', array(
              'class'=>'col-lg-6',
            ),
            $form->labelEx($model, 'address', array(
            )),
            Html::activeTextField($model, 'address', array(
            )),
            $form->error($model, 'address', array('class'=>'text-danger'))
          );?>
          <div class="clearfix"></div>
          <div class="col-lg-12">
            <button type="submit" class="btn btn-default btn-square"><?php echo Yii::t('common', 'Submit'); ?></button>
          </div>
          <?php $this->endWidget(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$allCities = json_encode($cities);
Yii::app()->clientScript->registerScript('club',
<<<EOT
  var allCities = {$allCities};
  $(document).on('change', '#Club_province_id', function() {
    var city = $('#Club_city_id'),
      cities = allCities[$(this).val()] || [];
    city.empty();
    $('<option value="">').appendTo(city);
    $.each(cities, function(id, name) {
      $('<option>').val(id).text(name).appendTo(city);
    });
  });
EOT
);

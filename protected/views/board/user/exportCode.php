<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1>导出注册码</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
        <div class="portlet-title">
          <h4>注册码信息</h4>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-collapse collapse in">
        <div class="portlet-body">
          <?php $form = $this->beginWidget('ActiveForm', [
            'htmlOptions'=>[
              'class'=>'clearfix row',
            ],
            'enableClientValidation'=>true,
          ]); ?>
          <?php echo Html::formGroup(
            $model, 'type', [
              'class'=>'col-lg-3 col-md-6',
            ],
            $form->labelEx($model, 'type', [
              'label'=>'类型',
            ]),
            $form->dropDownList($model, 'type', InvitationCode::getTypes(), [
              'prompt'=>'',
              'class'=>'form-control',
            ]),
            $form->error($model, 'type', ['class'=>'text-danger'])
          );?>
          <div class="clearfix"></div>
          <?php echo Html::formGroup(
            $model, 'status', [
              'class'=>'col-lg-3 col-md-6',
            ],
            $form->labelEx($model, 'status', [
              'label'=>'状态',
            ]),
            $form->dropDownList($model, 'status', InvitationCode::getAllStatus(), [
              'prompt'=>'',
              'class'=>'form-control',
            ]),
            $form->error($model, 'status', ['class'=>'text-danger'])
          );?>
          <div class="clearfix"></div>
          <?php echo Html::formGroup(
            $model, 'create_time', [
              'class'=>'col-lg-3 col-md-6',
            ],
            $form->labelEx($model, 'create_time', [
              'label'=>'生成时间',
            ]),
            '<br>从<br>' .
            CHtml::activeTextField($model, 'create_time[0]', [
              'class'=>'datetime-picker form-control',
              'data-date-format'=>'yyyy-mm-dd hh:ii:ss',
              // 'data-min-view'=>'2',
            ])
            . '<br>到<br>'
            . CHtml::activeTextField($model, 'create_time[1]', [
              'class'=>'datetime-picker form-control',
              'data-date-format'=>'yyyy-mm-dd hh:ii:ss',
              // 'data-min-view'=>'2',
            ]),
            $form->error($model, 'create_time', ['class'=>'text-danger'])
          );?>
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
Yii::app()->clientScript->registerPackage('datetimepicker');
Yii::app()->clientScript->registerScript('exportCode',
<<<EOT
  $(document).on('mousedown touchstart', '.datetime-picker', function() {
    $(this).datetimepicker({
      autoclose: true
    });
  });
EOT
);

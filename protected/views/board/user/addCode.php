<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1>新增注册码</h1>
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
          <div class="type type-0 hide">
            <?php echo Html::formGroup(
              $model, 'number', [
                'class'=>'col-lg-3 col-md-6'
              ],
              $form->labelEx($model, 'number'),
              Html::activeTextField($model, 'number', [
                'class'=>'form-control',
              ]),
              $form->error($model, 'number', ['class'=>'text-danger'])
            ); ?>
          </div>
          <div class="clearfix"></div>
          <div class="type type-1 hide">
            <?php echo Html::formGroup(
              $model, 'code', [
                'class'=>'col-lg-3 col-md-6'
              ],
              $form->labelEx($model, 'code'),
              Html::activeTextField($model, 'code', [
                'class'=>'form-control',
              ]),
              $form->error($model, 'code', ['class'=>'text-danger'])
            ); ?>
          </div>
          <div class="clearfix hidden-lg"></div>
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
Yii::app()->clientScript->registerScript('addCode',
<<<EOT
  $(document).on('change', '#InvitationCode_type', function() {
    var type = $(this).val()
    $('.type').addClass('hide')
    $('.type-' + type).removeClass('hide')
  });
  $('#InvitationCode_type').trigger('change')
EOT
);

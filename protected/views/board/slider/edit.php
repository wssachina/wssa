<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1><?php echo $model->isNewRecord ? '新增' : '编辑'; ?>Slider</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
          <div class="portlet-title">
              <h4>Slider信息</h4>
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
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'title', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'title', array(
                'label'=>'标题',
              )),
              Html::activeTextField($model, 'title'),
              $form->error($model, 'title', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'url', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'url', array(
                'label'=>'链接',
              )),
              Html::activeTextField($model, 'url'),
              $form->error($model, 'url', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'image', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'image', array(
                'label'=>'封面',
              )),
              $this->widget('ImageTextInput', [
                'model'=>$model,
                'name'=>'image',
              ], true),
              $form->error($model, 'image', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'create_time', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'create_time', array(
                'label'=>'时间',
              )),
              Html::activeTextField($model, 'create_time', array(
                'class'=>'datetime-picker',
                'data-date-format'=>'yyyy-mm-dd hh:ii:ss',
              )),
              '<div class="help">按此时间倒序，默认为当前时间</div>',
              $form->error($model, 'create_time', array('class'=>'text-danger'))
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
Yii::app()->clientScript->registerPackage('datetimepicker');
Yii::app()->clientScript->registerScript('slider',
<<<EOT
  $('.datetime-picker').datetimepicker({
    autoclose: true
  });
EOT
);

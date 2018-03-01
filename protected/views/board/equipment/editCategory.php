<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1><?php echo $model->isNewRecord ? '新增' : '编辑'; ?>器材分类</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
          <div class="portlet-title">
              <h4>器材分类信息</h4>
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
              $model, 'name_zh', array(
                'class'=>'col-lg-6',
              ),
              $form->labelEx($model, 'name_zh', array(
                'label'=>'中文名字',
              )),
              Html::activeTextField($model, 'name_zh'),
              $form->error($model, 'name_zh', array('class'=>'text-danger'))
            );?>
            <?php echo Html::formGroup(
              $model, 'name', array(
                'class'=>'col-lg-6',
              ),
              $form->labelEx($model, 'name', array(
                'label'=>'英文名字',
              )),
              Html::activeTextField($model, 'name'),
              $form->error($model, 'name', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'sequence', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'sequence', array(
                'label'=>'排序',
              )),
              Html::activeTextField($model, 'sequence', array(
                'class'=>'datetime-picker',
              )),
              $form->error($model, 'sequence', array('class'=>'text-danger'))
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
$this->widget('Editor');

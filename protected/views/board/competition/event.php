<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1><?php echo $model->name_zh; ?> - 项目</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
        <div class="portlet-title">
          <h4>比赛项目</h4>
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
            $model, 'events',array(
              'class'=>'col-lg-12',
            ),
            $form->labelEx($model, 'events', array(
              'label'=>'项目',
            )),
            '<div class="well">此处需要添加备注</div>',
            $this->widget('EventsForm', array(
              'model'=>$model,
              'name'=>'associatedEvents',
              'events'=>Events::getNormalEvents(),
              'isAdmin'=>true,
            ), true),
            $form->error($model, 'events', array('class'=>'text-danger'))
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

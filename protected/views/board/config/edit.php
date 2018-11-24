<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1><?php echo $model->isNewRecord ? '新增' : '编辑'; ?>配置</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
          <div class="portlet-title">
              <h4>配置信息</h4>
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
            <?php if ($model->isNewRecord): ?>
            <div class="text-danger col-lg-12">
              除非你明确知道新增的配置作用于何处，否则请联系管理员。
            </div>
            <?php echo Html::formGroup(
              $model, 'id', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'id', array(
                'label'=>'ID',
              )),
              Html::activeTextField($model, 'id'),
              $form->error($model, 'id', array('class'=>'text-danger'))
            );?>
            <?php endif; ?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'title_zh', array(
                'class'=>'col-lg-6',
              ),
              $form->labelEx($model, 'title_zh', array(
                'label'=>'中文标题',
              )),
              Html::activeTextField($model, 'title_zh'),
              $form->error($model, 'title_zh', array('class'=>'text-danger'))
            );?>
            <?php echo Html::formGroup(
              $model, 'title', array(
                'class'=>'col-lg-6',
              ),
              $form->labelEx($model, 'title', array(
                'label'=>'英文标题',
              )),
              Html::activeTextField($model, 'title'),
              $form->error($model, 'title', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'content_zh', array(
                'class'=>'col-lg-6',
              ),
              $form->labelEx($model, 'content_zh', array(
                'label'=>'中文正文',
              )),
              $form->textArea($model, 'content_zh', array(
                'class'=>'editor form-control'
              )),
              $form->error($model, 'content_zh', array('class'=>'text-danger'))
            );?>
            <?php echo Html::formGroup(
              $model, 'content', array(
                'class'=>'col-lg-6',
              ),
              $form->labelEx($model, 'content', array(
                'label'=>'英文正文',
              )),
              $form->textArea($model, 'content', array(
                'class'=>'editor form-control'
              )),
              $form->error($model, 'content', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'meta_title', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'meta_title', array(
                'label'=>'SEO标题',
              )),
              Html::activeTextField($model, 'meta_title'),
              $form->error($model, 'meta_title', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'meta_keywords', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'meta_keywords', array(
                'label'=>'SEO关键字',
              )),
              Html::activeTextField($model, 'meta_keywords'),
              $form->error($model, 'meta_keywords', array('class'=>'text-danger'))
            );?>
            <div class="clearfix"></div>
            <?php echo Html::formGroup(
              $model, 'meta_description', array(
                'class'=>'col-lg-12',
              ),
              $form->labelEx($model, 'meta_description', array(
                'label'=>'SEO描述',
              )),
              $form->textArea($model, 'meta_description', array(
                'class'=>'form-control',
                'rows'=>10,
              )),
              $form->error($model, 'meta_description', array('class'=>'text-danger'))
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
$this->widget('Editor');

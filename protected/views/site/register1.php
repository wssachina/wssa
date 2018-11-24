<?php $this->renderPartial('registerSide', $_data_); ?>
<div class="content-wrapper col-md-10 col-sm-9">
  <h3 class="has-divider text-highlight">
    第一步，请输入注册邀请码
  </h3>
  <div class="progress progress-striped active">
    <div class="progress-bar progress-bar-theme" style="width: 33%">
      <span class="sr-only"><?php echo Yii::t('common', 'Step One'); ?></span>
    </div>
  </div>
  <?php $form = $this->beginWidget('ActiveForm', array(
    'id'=>'register-form',
    'htmlOptions'=>array(
      //'class'=>'form-login',
      'role'=>'form',
    ),
  )); ?>
    <div class="register-area">
      <div class="col-xs-12">
        <?php echo Html::formGroup(
          $model, 'invitation_code', array(),
          $form->labelEx($model, 'invitation_code'),
          Html::activeTextField($model, 'invitation_code', array('type'=>'invitation_code')),
          $form->error($model, 'invitation_code', array('class'=>'text-danger')),
          '<div class="help">此处需要加入一个获取验证码渠道？</div>'
        );?>
      </div>
      <div class="clearfix"></div>
      <div class="col-xs-12">
        <p class="text-center">
          <button type="submit" class="btn btn-danger btn-lg">提交</button>
        </p>
      </div>
    </div>
  <?php $this->endWidget(); ?>
</div>

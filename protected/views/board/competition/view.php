<div class="row">
  <div class="col-lg-12">
    <div class="page-title">
      <h1>查看申请资料</h1>
    </div>
  </div>
  <!-- /.col-lg-12 -->
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="portlet portlet-default">
      <div class="portlet-heading">
        <div class="portlet-title">
          <h4>查看申请资料</h4>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="panel-collapse collapse in">
        <div class="portlet-body">
          <?php echo CHtml::errorSummary($competition, null, null, array(
            'class'=>'text-danger col-lg-12',
          )); ?>
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#baseinfo" role="tab" data-toggle="tab">基本信息</a></li>
            <li role="presentation"><a href="#organizer" role="tab" data-toggle="tab">主办团队</a></li>
            <li role="presentation"><a href="#schedule" role="tab" data-toggle="tab">赛程</a></li>
            <li role="presentation"><a href="#venue" role="tab" data-toggle="tab">场地</a></li>
            <li role="presentation"><a href="#sponsor" role="tab" data-toggle="tab">赞助</a></li>
            <li role="presentation"><a href="#other" role="tab" data-toggle="tab">其他</a></li>
            <li role="presentation"><a href="#admin" role="tab" data-toggle="tab">操作</a></li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="baseinfo">
              <dl>
                <dt>中文名</dt>
                <dd><?php echo $competition->name_zh; ?></dd>
                <dt>英文名</dt>
                <dd><?php echo $competition->name; ?></dd>
                <dt>类型</dt>
                <dd><?php echo $competition->getTypeText(); ?></dd>
                <dt><?php echo Yii::t('Competition', 'Date'); ?></dt>
                <dd><?php echo $competition->getDisplayDate(); ?></dd>
                <dt><?php echo Yii::t('Competition', 'Location'); ?></dt>
                <dd>
                  <?php $this->renderPartial('locations', $_data_); ?>
                </dd>
                <dt><?php echo Yii::t('Competition', 'Organizers'); ?></dt>
                <dd>
                  <?php foreach ($competition->organizer as $key=>$organizer): ?>
                  <?php if ($key > 0) echo Yii::t('common', ', '); ?>
                  <?php echo CHtml::mailto(Html::fontAwesome('envelope', 'a') . $organizer->user->getAttributeValue('name', true), $organizer->user->email); ?>
                  <?php endforeach; ?>
                </dd>
                <dt><?php echo Yii::t('Competition', 'Events'); ?></dt>
                <dd>
                  <table class="table fee-table">
                    <tbody>
                    <?php foreach ($competition->getMainEvents() as $competitionEvent): ?>
                      <tr>
                        <th><?php echo $competitionEvent->e->name; ?></th>
                        <th>领奖台</th>
                      </tr>
                      <?php foreach ($competitionEvent->children as $event): ?>
                      <tr>
                        <td><?php echo $event->e->name; ?></td>
                        <td><?php echo $event->podiums ? 'Top ' . $event->podiums : '待定'; ?></td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </dd>
                <dt><?php echo Yii::t('Competition', 'Entry Fee'); ?></dt>
                <dd>
                  <table class="table fee-table">
                    <thead>
                      <tr>
                        <th>报名时间</th>
                        <th>费用</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th><?php echo $competition->firstStage; ?></th>
                        <td><i class="fa fa-rmb"></i><?php echo $competition->entry_fee; ?></td>
                      </tr>
                      <?php if ($competition->hasSecondStage): ?>
                      <tr>
                        <th><?php echo $competition->secondStage; ?></th>
                        <td><i class="fa fa-rmb"></i><?php echo $competition->getEventFee('entry', Competition::STAGE_SECOND); ?></td>
                      </tr>
                      <?php endif; ?>
                      <?php if ($competition->hasThirdStage): ?>
                      <tr>
                        <th><?php echo $competition->thirdStage; ?></th>
                        <td><i class="fa fa-rmb"></i><?php echo $competition->getEventFee('entry', Competition::STAGE_THIRD); ?></td>
                      </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </dd>
                <?php if ($competition->person_num > 0): ?>
                <dt><?php echo Yii::t('Competition', 'Limited Number of Competitor'); ?></dt>
                <dd><?php echo $competition->person_num; ?></dd>
                <?php endif; ?>
                <?php if ($competition->reg_start > 0): ?>
                <dt><?php echo Yii::t('Competition', 'Registration Starting Time'); ?></dt>
                <dd><?php echo date('Y-m-d H:i:s', $competition->reg_start); ?></dd>
                <?php endif; ?>
                <dt><?php echo Yii::t('Competition', 'Registration Ending Time'); ?></dt>
                <dd><?php echo date('Y-m-d H:i:s', $competition->reg_end); ?></dd>
              </dl>
            </div>
            <div role="tabpanel" class="tab-pane" id="organizer">
              <dl>
                <dt>组织/参与过的比赛</dt>
                <dd class="information-container">
                  <?php echo $competition->application->organized_competition; ?>
                </dd>
                <dt>申请人自我阐述</dt>
                <dd class="information-container">
                  <?php echo $competition->application->self_introduction; ?>
                </dd>
                <dt>主办团队介绍</dt>
                <dd class="information-container">
                  <?php echo $competition->application->team_introduction; ?>
                </dd>
              </dl>
            </div>
            <div role="tabpanel" class="tab-pane" id="schedule">
              <dl>
                <dt>预估赛程</dt>
                <dd class="information-container">
                  <?php echo $competition->application->schedule; ?>
                </dd>
              </dl>
            </div>
            <div role="tabpanel" class="tab-pane" id="venue">
              <dl>
                <dt>场地</dt>
                <dd class="information-container">
                  <?php echo $competition->application->venue_detail; ?>
                </dd>
              </dl>
            </div>
            <div role="tabpanel" class="tab-pane" id="sponsor">
              <dl>
                <dt>预算</dt>
                <dd class="information-container">
                  <?php echo $competition->application->budget; ?>
                </dd>
                <dt>赞助</dt>
                <dd class="information-container">
                  <?php echo $competition->application->sponsor; ?>
                </dd>
              </dl>
            </div>
            <div role="tabpanel" class="tab-pane" id="other">
              <dl>
                <dt>其他</dt>
                <dd class="information-container">
                  <?php echo $competition->application->other; ?>
                </dd>
              </dl>
            </div>
            <div role="tabpanel" class="tab-pane" id="admin">
              <?php if ($competition->isUnconfirmed()): ?>
              <?php if ($competition->application->reason): ?>
              <div class="help-block">
                上一次被驳回原因如下，请确保已经修改完毕再提交申请：
                <p class="text-danger"><?php echo $competition->application->reason; ?></p>
              </div>
              <?php endif; ?>
              <?php echo CHtml::tag('button', [
                'class'=>'btn btn-square confirm btn-red',
                'data-id'=>$competition->id,
                'data-url'=>CHtml::normalizeUrl(['/board/competition/confirm']),
                'data-attribute'=>'status',
                'data-value'=>$competition->status,
                'data-name'=>$competition->name_zh,
              ], '确认无误，提交！') ;?>
              <?php elseif ($competition->isConfirmed() && ($this->user->isAdministrator() || $this->user->isWCADelegate())): ?>
              <?php $form = $this->beginWidget('ActiveForm', array(
                'htmlOptions'=>array(
                  'class'=>'clearfix row',
                ),
                'enableClientValidation'=>true,
              )); ?>
              <?php echo $form->hiddenField($competition, 'status', ['value'=>Competition::STATUS_HIDE]); ?>
              <div class="col-lg-12">
                <button type="submit" class="btn btn-square btn-green">通过</button>
              </div>
              <?php $this->endWidget(); ?>
              <hr>
              <?php $form = $this->beginWidget('ActiveForm', array(
                'htmlOptions'=>array(
                  'class'=>'clearfix row',
                ),
                'enableClientValidation'=>true,
              )); ?>
              <?php echo Html::formGroup(
                $competition->application, 'reason', array(
                  'class'=>'col-lg-12',
                ),
                $form->labelEx($competition->application, 'reason', array(
                  'label'=>'驳回原因',
                  'required'=>true,
                )),
                $form->textArea($competition->application, 'reason', array(
                  'class'=>'form-control'
                )),
                $form->error($competition->application, 'reason', array('class'=>'text-danger'))
              );?>
              <?php echo $form->hiddenField($competition, 'status', ['value'=>Competition::STATUS_UNCONFIRMED]); ?>
              <div class="col-lg-12">
                <button type="submit" class="btn btn-square btn-orange">驳回</button>
              </div>
              <?php $this->endWidget(); ?>
              <hr>
              <?php $form = $this->beginWidget('ActiveForm', array(
                'htmlOptions'=>array(
                  'class'=>'clearfix row',
                ),
                'enableClientValidation'=>true,
              )); ?>
              <?php echo Html::formGroup(
                $competition->application, 'reason', array(
                  'class'=>'col-lg-12',
                ),
                $form->labelEx($competition->application, 'reason', array(
                  'label'=>'拒绝原因',
                  'required'=>true,
                )),
                $form->textArea($competition->application, 'reason', array(
                  'class'=>'form-control'
                )),
                $form->error($competition->application, 'reason', array('class'=>'text-danger'))
              );?>
              <?php echo $form->hiddenField($competition, 'status', ['value'=>Competition::STATUS_REJECTED]); ?>
              <div class="col-lg-12">
                <button type="submit" class="btn btn-square btn-red">拒绝</button>
              </div>
              <?php $this->endWidget(); ?>
              <div class="clearfix"></div>
              <?php endif; ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

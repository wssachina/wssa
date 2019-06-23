<dl>
  <?php if ($competition->type == Competition::TYPE_WCA): ?>
  <dt><?php echo Yii::t('Competition', 'WCA Competition'); ?></dt>
  <dd>
    <?php echo Yii::t('Competition', 'This competition is recognized as an official World Cube Association competition. Therefore, all competitors should be familiar with the {regulations}.', array(
    '{regulations}'=>CHtml::link(Yii::t('Competition', 'WCA regulations'), $competition->getWcaRegulationUrl(), array('target'=>'_blank')),
  ));?>
  </dd>
  <?php endif; ?>
  <?php if ($competition->wca_competition_id != ''): ?>
  <dt><?php echo Yii::t('Competition', 'WCA Official Page'); ?></dt>
  <dd><?php echo CHtml::link($competition->getWcaUrl(), $competition->getWcaUrl(), array('target'=>'_blank')); ?>
  <?php endif; ?>
  <?php if ($competition->tba == Competition::NO): ?>
  <dt><?php echo Yii::t('Competition', 'Date'); ?></dt>
  <dd><?php echo $competition->getDisplayDate(); ?></dd>
  <dt><?php echo Yii::t('Competition', 'Location'); ?></dt>
  <dd>
    <?php $this->renderPartial('locations', $_data_); ?>
  </dd>
  <?php endif; ?>
  <dt><?php echo Yii::t('Competition', 'Organizers'); ?></dt>
  <dd>
    <?php if ($competition->isOld()): ?>
    <?php echo OldCompetition::formatInfo($competition->old->getAttributeValue('organizer')); ?>
    <?php else: ?>
    <?php foreach ($competition->organizer as $key=>$organizer): ?>
    <?php if ($key > 0) echo Yii::t('common', ', '); ?>
    <?php echo CHtml::mailto(Html::fontAwesome('envelope', 'a') . $organizer->user->getAttributeValue('name', true), $organizer->user->email); ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </dd>
  <?php if ($competition->delegate !== array() && !$competition->multi_countries): ?>
  <dt><?php echo Yii::t('Competition', $competition->type == Competition::TYPE_WCA ? 'Delegates' : 'Main Judge'); ?></dt>
  <dd>
    <?php foreach ($competition->delegate as $key=>$delegate): ?>
    <?php if ($key > 0) echo Yii::t('common', ', '); ?>
    <?php echo CHtml::mailto(Html::fontAwesome('envelope', 'a') . $delegate->user->getAttributeValue('name', true), $delegate->user->email); ?>
    <?php endforeach; ?>
  </dd>
  <?php elseif ($competition->isOld() && $competition->old->getAttributeValue('delegate')): ?>
  <dt><?php echo Yii::t('Competition', $competition->type == Competition::TYPE_WCA ? 'Delegates' : 'Main Judge'); ?></dt>
  <dd>
    <?php echo OldCompetition::formatInfo($competition->old->getAttributeValue('delegate')); ?>
  </dd>
  <?php endif; ?>
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
  <?php if ($competition->tba == Competition::NO): ?>
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
  <?php endif; ?>
  <?php if ($competition->person_num > 0): ?>
  <dt><?php echo Yii::t('Competition', 'Limited Number of Competitor'); ?></dt>
  <dd><?php echo $competition->person_num; ?></dd>
  <?php endif; ?>
  <?php if ($competition->reg_start > 0 && $competition->tba == Competition::NO): ?>
  <dt><?php echo Yii::t('Competition', 'Registration Starting Time'); ?></dt>
  <dd>
    <?php echo date('Y-m-d H:i:s', $competition->reg_start); ?>
    <?php if (time() < $competition->reg_start): ?>
    <?php echo Html::countdown($competition->reg_start); ?>
    <?php endif; ?>
  </dd>
  <?php endif; ?>
  <?php if ($competition->cancellation_end_time > 0 && $competition->tba == Competition::NO): ?>
  <dt><?php echo Yii::t('Competition', 'Registration Cancellation Deadline'); ?></dt>
  <dd><?php echo date('Y-m-d H:i:s', $competition->cancellation_end_time); ?></dd>
  <dt><?php echo Yii::t('Competition', 'Registration Restarting Time'); ?></dt>
  <dd>
    <?php echo date('Y-m-d H:i:s', $competition->reg_reopen_time); ?>
    <div class="text-info"><?php echo Yii::t('Competition', 'You can not register between {start} and {end}.', [
      '{start}'=>date('Y-m-d H:i:s', $competition->cancellation_end_time),
      '{end}'=>date('Y-m-d H:i:s', $competition->reg_reopen_time),
    ]); ?></div>
  </dd>
  <?php endif; ?>
  <?php if ($competition->tba == Competition::NO): ?>
  <dt><?php echo Yii::t('Competition', 'Registration Ending Time'); ?></dt>
  <dd>
    <?php echo date('Y-m-d H:i:s', $competition->reg_end); ?>
    <?php if (time() > $competition->reg_start && !$competition->isRegistrationFull() && !$competition->isRegistrationEnded()): ?>
    <?php echo Html::countdown($competition->reg_end, [
      'data-total-days'=>$competition->reg_start > 0 ? floor(($competition->reg_end - $competition->reg_start) / 86400) : 30,
    ]); ?>
    <?php endif; ?>
  </dd>
  <?php endif; ?>
  <?php if (trim(strip_tags($competition->getAttributeValue('information'), '<img>')) != ''): ?>
  <dt><?php echo Yii::t('Competition', 'About the Competition'); ?></dt>
  <dd>
    <?php echo $competition->getAttributeValue('information'); ?>
  </dd>
  <?php endif; ?>
</dl>

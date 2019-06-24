<dl>
  <?php if ($competition->isSanctionedCompetition()): ?>
  <dt>世界竞技叠杯运动协会认证比赛</dt>
  <dd>
    该比赛是世界竞技叠杯运动协会官方认证的比赛，所有选手需要熟知<a href="http://www.thewssa.com/about/rules/" target="_blank">WSSA比赛规则</a>。
  </dd>
  <?php endif; ?>
  <?php if ($competition->wssa_url != ''): ?>
  <dt>WSSA官方页面</dt>
  <dd><?php echo CHtml::link($competition->wssa_url, $competition->wssa_url, array('target'=>'_blank')); ?>
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

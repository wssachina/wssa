<?php if ($this->user->isOrganizer() && isset($competition->organizers[$this->user->id])
  || $this->user->isAdministrator()): ?>
<div class="col-lg-12">
  <?php echo CHtml::link(Yii::t('common', 'Edit'), ['/board/competition/edit', 'id'=>$competition->id], [
    'class'=>'btn btn-xs btn-theme',
  ]); ?>
</div>
<?php endif; ?>
<?php $this->setPageTitle(array('Links')); ?>
<?php $this->setTitle('Links'); ?>
<?php $this->breadcrumbs = array(
  'Links'
); ?>
<?php $this->renderPartial('aboutSide', $_data_); ?>
<div class="content-wrapper col-md-10 col-sm-9">
  <?php foreach (Config::getConfig('links.*') as $key=>$link): ?>
  <?php echo CHtml::link($link->getAttributeValue('content'), $link->getAttributeValue('title'), ['target'=>'_blank']); ?>
  <?php endforeach; ?>
</div>

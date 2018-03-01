<?php $this->setPageTitle(array('Club')); ?>
<?php $this->setTitle('Club'); ?>
<?php $this->breadcrumbs = array(
    'Club'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo Config::getConfig('club') ? Config::getConfig('club')->getAttributeValue('content') : ''; ?>
</div>

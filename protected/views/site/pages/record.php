<?php $this->setPageTitle(array('Records')); ?>
<?php $this->setTitle('Records'); ?>
<?php $this->breadcrumbs = array(
    'Records'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo Config::getConfig('record') ? Config::getConfig('record')->getAttributes('content') : ''; ?>
</div>

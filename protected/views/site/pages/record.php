<?php $config = Config::getConfig('record'); ?>
<?php $this->setPageTitle(array('Records')); ?>
<?php $this->setTitle('Records'); ?>
<?php $this->setMetaInfo($config); ?>
<?php $this->breadcrumbs = array(
    'Records'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo $config ? $config->getAttributeValue('content') : ''; ?>
</div>

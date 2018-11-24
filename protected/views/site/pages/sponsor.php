<?php $config = Config::getConfig('sponsor'); ?>
<?php $this->setPageTitle(array('Sponsor')); ?>
<?php $this->setTitle('Sponsor'); ?>
<?php $this->setMetaInfo($config); ?>
<?php $this->breadcrumbs = array(
    'Sponsor'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo $config ? $config->getAttributeValue('content') : ''; ?>
</div>

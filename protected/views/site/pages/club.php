<?php $config = Config::getConfig('club'); ?>
<?php $this->setPageTitle(array('Club')); ?>
<?php $this->setTitle('Club'); ?>
<?php $this->setMetaInfo($config); ?>
<?php $this->breadcrumbs = array(
    'Club'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo $config ? $config->getAttributeValue('content') : ''; ?>
</div>

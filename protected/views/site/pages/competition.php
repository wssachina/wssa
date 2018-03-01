<?php $this->setPageTitle(array('Competitions')); ?>
<?php $this->setTitle('Competitions'); ?>
<?php $this->breadcrumbs = array(
    'Competitions'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo Config::getConfig('competition') ? Config::getConfig('competition')->getAttributeValue('content') : ''; ?>
</div>

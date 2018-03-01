<?php $this->setPageTitle(array('Sponsor')); ?>
<?php $this->setTitle('Sponsor'); ?>
<?php $this->breadcrumbs = array(
    'Sponsor'
); ?>
<div class="content-wrapper col-md-12">
  <?php echo Config::getConfig('sponsor') ? Config::getConfig('sponsor')->getAttributeValue('content') : ''; ?>
</div>

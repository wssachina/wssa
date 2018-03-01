<?php $this->setPageTitle(array('About')); ?>
<?php $this->setTitle('About'); ?>
<?php $this->breadcrumbs = array(
    'About'
); ?>
<?php $this->renderPartial('aboutSide', $_data_); ?>
<div class="content-wrapper col-md-10 col-sm-9">
  <?php echo Config::getConfig('about') ? Config::getConfig('about')->getAttributeValue('content') : ''; ?>
</div>

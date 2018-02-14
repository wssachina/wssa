<?php $this->setPageTitle(['Contact']); ?>
<?php $this->setTitle('Contact'); ?>
<?php $this->breadcrumbs = array(
  'Contact'
); ?>
<?php $this->renderPartial('aboutSide', $_data_); ?>
<div class="content-wrapper col-md-10 col-sm-9">
  <?php echo Config::getConfig('about') ? Config::getConfig('about')->getAttributes('content') : ''; ?>
</div>
